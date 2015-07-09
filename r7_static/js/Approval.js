(function() {
	$(document).ready(function(){
		// urls
		var getURL = "/scoreManagement/score/getModifyScores"
		var postURL = "/scoreManagement/score/approvalRequests"; 

		// 获取该教师需要审批的条目
		API.get(getURL, function(data) {
			var records = data;
			if (records.length == 0) { // 没有需要审批的申请
				$("#info").show();
				$("#table").hide();
			}
			else { // 有需要审批的申请
				$("#info").hide();
				$("#table").show();	
				// 根据获取的审批列表画出表格
				for (var i = 0; i < records.length; i++) {
					$("#tableBody").append(getNewRow(i, records));
				};
				btnListener(records);
			}
		});

		function getNewRow(num, records) {
			var rec = records[num];
			var newTr = "<tr>";
			var agreeCheck = "<input type='radio' name='optionsRadios" + num + "' id='optionsRadios1' value='true'>同意";
			var disCheck = "<input type='radio' name='optionsRadios" + num + "' id='optionsRadios2' value='false'>拒绝"
			var inputReason = "<input id='reason" + num + "' type='text' placeholder='若拒绝，请填写拒绝理由' style='width:70%'>"
			var newRow = newTr
							+ "<td rowspan='2'>" + (rec.requestId) + "</td>"
							+ "<td>" + rec.courseName + "</td>"
							+ "<td>" + rec.teacherName + "</td>"
							+ "<td>" + rec.studentName + "</td>"
							+ "<td>" + rec.studentId + "</td>"
							+ "<td>" + rec.score + "</td>"
							+ "<td>" + rec.mScore + "</td>"
							+ "<td>" + rec.mInfo + "</td>"
						 + "</tr>"
						 + "<tr>"
						 	+ "<td>" + agreeCheck + "</td>"
						 	+ "<td>" + disCheck + "</td>"
						 	+ "<td colspan='5'>" + inputReason + "</td>"
						 + "</tr>";
			return newRow;
		}

		// 按下确认提交按钮
		function btnListener(records) {
			$("#btn").click(function() {
				var postInfo = new Array();
				for (var i = 0; i < records.length; i++) {
					var res = new Object();
					var checkName = "input[name='optionsRadios" + i + "']:checked";
					var reason = "#reason" + i;

					res.requestId = records[i].requestId;
					res.approval = $(checkName).val();
					res.info = "";
					if (res.approval == "false") {
						res.info = $(reason).val();
						if (res.info == "") {
							alert("请填写拒绝理由！");
							return false;
						}
						else {
							postInfo.push(res);		
						}
					}
					if (res.approval == "true") {
						postInfo.push(res);	
					}
				};
				// 上传
				API.post(postURL, { requests: JSON.stringify(postInfo) }, function(data) {
					// 提交完成刷新界面
					window.location.reload();	
				});
				
				
			});
		}	
	})
}).call(this);