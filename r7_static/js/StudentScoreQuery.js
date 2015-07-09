(function() {
	$(document).ready(function(){
		// urls
		var studentInfoURL = "/scoreManagement/student/studentInfo";
		var courseScoreURL = "/scoreManagement/score/courseScore";
		var coursePlanURL = "/scoreManagement/score/coursePlan";
		// 查询方式
 		var method; 

		// 展示学生基本信息
		var studentInfo; // 学生基本信息

		// 获取学生基本信息
		API.get(studentInfoURL, function(data) {
			studentInfo = data;

			// 显示基本信息
			$("#name").html(studentInfo.studentName);
			$("#id").html(studentInfo.studentId);
			$("#college").html(studentInfo.sCollege);
			$("#class").html(studentInfo.sClass);


		})
		
		// 根据所选择的查询方式显示不同表单
		$("#method").on("change", function() {
			method = $("#method").val();
			var disp_keyword = $("#disp_keyword");
			var disp_duration = $("#disp_duration");
			if (method == "all") { // 查询全部在校成绩
				disp_keyword.hide(1000);
				disp_duration.hide(1000);
			}
			if (method == "keyword") { // 按课程关键字查询
				disp_keyword.show(1000);
				disp_duration.hide(1000);
			}
			if (method == "duration") { // 按学年-学期查询
				// 根据学生所在年级显示学年-学期的选项
				var grade = parseInt(studentInfo.sGrade);
				// XXX 没有解决“第一学年是从秋冬学期开始，没有春夏”这种类似问题
				$("#beginYear").empty();
				$("#beginYear").append("<option value='"+ grade + "'>" + grade + "-" + (grade+1) + "</option>");
				$("#beginYear").append("<option value='"+ (grade+1) + "'>" + (grade+1) + "-" + (grade+2) + "</option>");
				$("#beginYear").append("<option value='"+ (grade+2) + "'>" + (grade+2) + "-" + (grade+3) + "</option>");
				$("#beginYear").append("<option value='"+ (grade+3) + "'>" + (grade+3) + "-" + (grade+4) + "</option>");
				$("#endYear").empty();
				$("#endYear").append("<option value='"+ grade + "'>" + grade + "-" + (grade+1) + "</option>");
				$("#endYear").append("<option value='"+ (grade+1) + "'>" + (grade+1) + "-" + (grade+2) + "</option>");
				$("#endYear").append("<option value='"+ (grade+2) + "'>" + (grade+2) + "-" + (grade+3) + "</option>");
				$("#endYear").append("<option value='"+ (grade+3) + "'>" + (grade+3) + "-" + (grade+4) + "</option>");
				
				disp_keyword.hide(1000);
				disp_duration.show(1000);
			}
			if (method == "plan") { // 查看培养方案修读情况
				disp_keyword.hide(1000);
				disp_duration.hide(1000);
			}
		});

		// 获取课程搜索/过滤选项
		$("#queryBtn").on("click", function(){
			// 查询信息保存在query对象里
			var query = new Object();

			if (method == "keyword") { // 按课程关键字查询
				query.query = $("#inputCourseKeyword").val();
				if (query.query == "") { // keyword为空
					method = "all";  // 则查询全部成绩
				}
			}
			if (method == "duration") { // 按学年-学期查询
				query.startTermYear = $("#beginYear").val();
				query.startTermSemester = $("#beginTerm").val();
				query.endTermYear = $("#endYear").val();
				query.endTermSemester = $("#endTerm").val();
			}

			if (method == "plan") { // 查询培养方案修读计划
				API.get(coursePlanURL, function(data) {
					display(data);
				});
			}
			else { // 只是查询成绩
				// 所查询的成绩结果
	 			if (method == "all") { // 查询全部成绩
	 				var url2 = courseScoreURL;
	 			}
	 			else {
	 				var url2 = courseScoreURL + "?" + $.param(query);			
	 			}
							
				API.get(url2, function(data) {
					display(data);
				});
			}
			
			
		});

		$("#searchForm").submit(function(e) {
			e.preventDefault();
		});
		
		// 展示查询结果
		function display(res){
			if (typeof(res) == "undefined") { 
				// 如果没有所查询的结果，显示相关信息
				$("#scoreTable").hide();
				$("#notFoundInfo").show();
			}
			else {
				// 否则显示查询到的结果
				$("#scoreTable").show();
				$("#gpa").html("GPA: " + res.GPA.GPA);
				$("#mgpa").html("主修专业GPA: " + res.GPA.MGPA);
				
				// 清除之前的成绩搜素结果
				$("#tableBody").empty(); 
				
				// 所有搜索课程
				var courses = res.courses;
				
				// 为每门课程添加一行表格进行显示 
				for (var i = 0; i < courses.length; i++) {
					$("#tableBody").append(getNewRow(courses[i]));
				};
			}		
		};

		// 为每门课程成绩添加新的一行
		function getNewRow(course) {
			// 备注（判断该门课程是否及格）
			var note = "<td></td>"; 
			var tr = "<tr>"
			if (course.state == 2 && course.score < 60) {
				note = "<td>注意补考</td>";
			}
			if (course.isRestudy == true) { // 重修标记
				note = "<td>重修课程</td>";
			}

			switch(course.state){
				case 1: // 正在修读
					tr = "<tr class = 'danger'>";
					break;
				case 2: // 已获得学分
					tr = "<tr class = 'success'>";
					break;
				default:
					break;
			}
			var newRow = tr
							+ "<td>" + course.classId + "</td>"
							+ "<td>" + course.courseName + "</td>"
							+ "<td>" + course.score + "</td>"
							+ "<td>" + course.credit + "</td>" 
							+ "<td>" + course.grade + "</td>"
							+ note
						+ "</tr>";

			return newRow;
		};

	})
}).call(this);