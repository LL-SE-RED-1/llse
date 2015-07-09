var classId;
(function () {
	$(document).ready(function (){
       
        //get class id
		classId = getHashParam("classId");
//        classId="weijifen1-2014-2015";//for testing
        var classInfoURL="/scoreManagement/score/classInfo";
        var importURL="/scoreManagement/score/import";
        var downloadURL="/scoreManagement/score/downloadExcel";
        var classInfo,teacher,courseName,isWithOnlineExam;
        
        //get class information
        API.get(baseURL+classInfoURL, {classId:classId}, function(data, status) {
			classInfo = data.data;
            teacher = classInfo.teacher;
			courseName = classInfo.courseName;
            isWithOnlineExam = classInfo.isWithOnlineExam;
            console.log(classInfo);
            if(isWithOnlineExam) document.getElementById('importScores').setAttribute('style', "");//隐藏导入按钮
	       });
//        .fail(function(){
//            alert("载入班级信息失败");
//        });
        
        document.getElementById('classId').setAttribute('value', classId);
        document.getElementById("downloadExcel").onclick = function (){
            window.open(baseURL+downloadURL+"?classId="+classId, '_blank');
            
        };
        
       document.getElementById("importScores").onclick = function(){
         if(classInfo.isWithOnlineExam==true){
                $.post(baseURL+importURL,{classId:classId})
                    .fail(function()// importing fails
                        {   alert('在线考试成绩导入失败！');
                        })
                    .done(function() {
                    alert('在线考试成绩导入成功！');
                    window.location.href=frontURL+"/scoreAnalytics.html";
                });
            }   
      else {   alert('您没有在线考试！');}
    }
    });
}).call(this);

         