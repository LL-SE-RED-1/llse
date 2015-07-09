(function() {
	$(document).ready(function(){
		// urls
		var scoreInfoURL = "/scoreManagement/score/classScore?";
		var courseTeacherURL = "/scoreManagement/teacher/getTeacherCourses?";
		var modifyInfoURL = "/scoreManagement/score/modifyScores";
		var classInfoURL = "/scoreManagement/score/classInfo?";
		
		// post data
		var modiInfo = new Object();
		modiInfo.records = new Array();

		// 当前教学班编号
		var classId = getHashParam("classId");

		// 获取当前教学班课程基本信息
		API.get(classInfoURL + $.param({classId:classId}), function(data) {
			var classInfo = data;
			var courseId = classInfo.courseId;
			var teacherId = classInfo.teacherId;
			$("#courseName").html(classInfo.courseName);
			getTeachers(courseId, teacherId);
		});

		$("#selectForm").submit(function(e) {
			e.preventDefault();
		});
		
		// 获取当前教学班的所有学生及成绩信息
		API.get(scoreInfoURL + $.param({classId:classId}), function(data) {
			var students = data;

			// 显示教学班的学生及成绩列表
			for (var i = 0; i < students.length; i++) {
				$("#tableBody").append(getNewRow(i, students));
				if (students[i].isPending) {
					var trID = "#trOri" + i;
				   	$(trID).addClass("warning"); 
				}
			};

			modiBtn();
			cancelBtn();
			saveBtn(students);
			confirmBtn();
		});

		// 新建一行
		function getNewRow(num, students) {
			var student = students[num];
			var trOri = "<tr id='trOri" + num + "' >";
			var trModi1 = "<tr id='trModi1" + num + "' style='display: none'>";
			var trModi2 = "<tr id='trModi2" + num + "' style='display: none'>";
			var btnModi = "<button id='btnModi' value='" + num + "' type='button' class='btn btn-primary btn-xs'>修改</button>";
			var inputScore = "<input id='input" + num + "' type='number' style='width:60px' placeholder='" + student.score + "'>";
			var btnSave = "<button id='save' value='" + num + "' type='button' class='btn btn-primary btn-xs'>保存</button>";
			var btnCancel = "<button id='cancel' value='" + num + "' type='button' class='btn btn-default btn-xs'>取消</button>";
			var inputReason = "<input id='reason" + num + "' type='text' style='width:100%'>"
			
			if (student.isPending) { // 该条成绩正处于审批阶段，无法修改
				var newRow = trOri
			   					+ "<td>" + student.studentId + "</td>"
			   					+ "<td>" + student.studentName + "</td>"
			   					+ "<td>" + student.mScore + "</td>"
			   					+ "<td>" + student.mGrade + "</td>"
			   					+ "<td>" + (student.mIsAbsent?"是":"否") + "</td>"
			   					+ "<td>" + "审批中" + "</td>"
			   				+ "</tr>";
			}
			else { // 该条成绩没有处于审批状态，可以修改
				var newRow = trOri
			   					+ "<td>" + student.studentId + "</td>"
			   					+ "<td>" + student.studentName + "</td>"
			   					+ "<td id='score" + num + "'>" + student.score + "</td>"
			   					+ "<td id='grade" + num + "'>" + student.grade + "</td>"
			   					+ "<td id='checkBox" + num + "'>" + (student.isAbsent?"是":"否") + "</td>"
			   					+ "<td id='state" + num + "'>" + btnModi + "</td>"
			   				+ "</tr>"
			   				+ trModi1
			   					+ "<td>" + student.studentId + "</td>"
			   					+ "<td>" + student.studentName + "</td>"
			   					+ "<td>" + inputScore + "</td>"
			   					+ "<td></td>" 
			   					+ "<td>" + "<input id='check" + num + "' type='checkBox'> 缺考" + "</td>"
			   					+ trModi2
			   						+ "<td>修改理由:</td>"
			   						+ "<td colspan='4'>" + inputReason + "</td>"
			   						+ "<td>" + btnSave + btnCancel + "</td>"
			   					+ "</tr>"
			   				+ "</tr>";
			}
			
			return newRow;
		};

		function getTeachers(courseId, teacherId) {
			// 获取当前课程的所有开课教师信息
			API.get(courseTeacherURL + $.param({courseId:courseId}), function(data) {
				var teachers = data;

				// 显示该课程的开课老师
				for (var i = 0; i < teachers.length; i++) {
					if (teachers[i].teacherId == teacherId)
						continue; // 出现的审批教师列表不能包括当前操作教师
					$("#teacher1").append("<option value='" + teachers[i].teacherId + "'>" + teachers[i].teacherName + "</option>");
					$("#teacher2").append("<option value='" + teachers[i].teacherId + "'>" + teachers[i].teacherName + "</option>");
				};
			});
		}
		

		// 按下修改按钮后表格的变化
		function modiBtn() {
			$("button#btnModi").bind("click", function() {
				var num = $(this).val();
				var trOri = "#trOri" + num;
				var trModi1 = "#trModi1" + num;
				var trModi2 = "#trModi2" + num;
				$(trOri).hide();
				$(trModi1).show();
				$(trModi2).show();
			});
		}

		function cancelBtn() {
			// 按下取消按钮后表格的变化
			$("button#cancel").bind("click", function() {
				var num = $(this).val();
				var trOri = "#trOri" + num;
				var trModi1 = "#trModi1" + num;
				var trModi2 = "#trModi2" + num;
				$(trOri).show();
				$(trModi1).hide();
				$(trModi2).hide();
			});
		}
		
		function saveBtn(students) {
			
			// 按下保存按钮
			$("button#save").bind("click", function() {
				var modiStu = new Object();
				
				var num = $(this).val();

				// 记录当前修改的学生的id
				modiStu.studentId = students[num].studentId;

				// 获取修改的成绩和绩点
				var inputNum = "#input" + num;
				modiStu.mScore = regularizeScore($(inputNum).val());
				modiStu.mGrade = calculateGrade(modiStu.mScore, false);

				// 获取缺考是否被标记
				var checkNum = "#check" + num;
				modiStu.mIsAbsent = $(checkNum).is(':checked'); 
				if (modiStu.mIsAbsent) {
					modiStu.mScore = 0;
					modiStu.mGrade = calculateGrade(modiStu.mScore, true);
				}

				// 获取修改成绩的申请理由
				var reasonNum = "#reason" + num;
				modiStu.mInfo = $(reasonNum).val();

				// 处理修改成绩和申请为空的情况
				if (isNaN(modiStu.mScore) || modiStu.mInfo == "") {
					alert("请填写修改分数和修改理由！");
					return false;
				}
				else {
					// 将该条记录添加到要提交给后端的信息里
					modiInfo.records.push(modiStu);

					// 更新显示的成绩
					var scoreID = "#score" + num;
					var gradeID = "#grade" + num;
					var checkID = "#checkBox" + num;
					$(scoreID).html(modiStu.mScore); 
					$(gradeID).html(modiStu.mGrade);
					$(checkID).html((modiStu.mIsAbsent?"是":"否"));

					// 去掉该条成绩的修改按钮，将状态修改为已保存
					var stateID = "#state" + num;
					$(stateID).html("已保存,请提交");
					var trID = "#trOri" + num;
					$(trID).addClass("danger");
				}
				
				// 隐藏修改栏
				var trOri = "#trOri" + num;
				var trModi1 = "#trModi1" + num;
				var trModi2 = "#trModi2" + num;
				$(trOri).show();
				$(trModi1).hide();
				$(trModi2).hide();
			});
		}
		
		function confirmBtn() {
			// 按下确认提交
			$("#confirm").click(function() {
				var teacher1 = $("#teacher1").val();
				var teacher2 = $("#teacher2").val();
				if (teacher1 == teacher2) { // 无法选择两名相同的教师
					alert("请选择两名不同的教师！");
					return false;
				} 
				else {
					modiInfo.mTeacherId1 = teacher1;
					modiInfo.mTeacherId2 = teacher2;
					modiInfo.classId = classId;
					// POST
					API.post(modifyInfoURL, { request: JSON.stringify(modiInfo) }, function(data) {
						// 提交完成刷新界面
						window.location.reload();
					});
				}
			});
		}
		
	})
}).call(this);