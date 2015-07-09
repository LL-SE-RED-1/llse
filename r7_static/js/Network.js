/**
 * Created by imsun on 6/11/15.
 */

/**
 * mock data for test
 * @type { *:{
 *  isMock: boolean,
 *  code: number,
 *  msg: string,
 *  data: *
 * }}
 */
var MockObject = window.MockObject = {
  '/scoreManagement/score/coursePlan': {
    isMock: true, // set to `true` when you want to use mock data
    code: 0,
    msg: 'foo error',
    data: {
        "courses": [
            {
                "classId": "bianyiyuanli-2014-2015",
                "courseName": "编译原理",
                "score": 90,
                "grade": 4.5,
                "credit": 2,
                "isAbsent": false,
                "termYear": 2015,
                "termSemester": 1,
                "isRestudy": false, // 重修     
                "state": 2 // 0:没获得学分 1：正在修读 2：已获得学分
            },
            {
                "classId": "weijifen1-2013-2014",
                "courseName": "微积分1",
                "score": 59,
                "grade": 0.0,
                "credit": 4,
                "isAbsent": false,
                "termYear": 2015,
                "termSemester": 1,
                "isRestudy": false, // 重修     
                "state": 0 // 0:没获得学分 1：正在修读 2：已获得学分
            },
            {
                "classId": "weijifen1-2014-2015",
                "courseName": "微积分1",
                "score": 80,
                "grade": 3.5,
                "credit": 4,
                "isAbsent": false,
                "termYear": 2015,
                "termSemester": 1,
                "isRestudy": true, // 重修     
                "state": 2 // 0:没获得学分 1：正在修读 2：已获得学分
            },
            {
                "classId": "jisuanjiwangluo",
                "courseName": "计算机网络",
                "score": 0,
                "grade": 0.0,
                "credit": 3,
                "isAbsent": false,
                "termYear": 2015,
                "termSemester": 1,
                "isRestudy": false, // 重修     
                "state": 0 // 0:没获得学分 1：正在修读 2：已获得学分
            }
        ],
        "GPA": {
            "GPA": 2.3,
            "MGPA": 2.3
        }
    }
  },
  '/scoreManagement/scoreModification/scoreInfo?classId=1': {
    isMock: false, // set to `true` when you want to use mock data
    code: 0,
    msg: 'foo error',
    data: [
        {
              "studentId": "学生ID",
              "studentName": "学生姓名",
              "score": 100,
              "grade": 5.0,
              "isAbsent" : false,
              "mScore": 100,
              "mGrade": 5.0,
              "mIsAbsent": false,
              "isPending": false
        },
        {
              "studentId": "学生ID",
              "studentName": "学生姓名",
              "score": 100,
              "grade": 5.0,
              "isAbsent" : false,
              "mScore": 100,
              "mGrade": 5.0,
              "mIsAbsent": false,
              "isPending": true
        }
    ]
  },
  '/scoreManagement/scoreModification/courseTeacher?courseId=10': {
    isMock: false, // set to `true` when you want to use mock data
    code: 0,
    msg: 'foo error',
    data: [
      {
          "teacherId": "教师ID",
          "teacherName": "教师姓名"
      }
    ]
  },
  '/scoreManagement/score/classInfo': {
    isMock: false, // set to `true` when you want to use mock data
    code: 0,
    msg: 'foo error',
    data: {
        "courseId":10,
        "teacherId":20,
        "teacher":"开课教师",
        "courseName": "课程名称",
        "isWithOnlineExam": "是否拥有在线考试成绩"
    }
  },
  '/scoreManagement/teacher/clazz': {
    isMock: false, // set to `true` when you want to use mock data
    code: 0,
    msg: 'foo error',
    data: {
      "withScores": [
        {
          "classId": "班级编号",
          "courseName": "课程名称",
          "classTerm": "开课学期：xxx年x学期"
        }
      ],
      "withoutScores": [
        {
          "classId": "班级编号",
          "courseName": "课程名称",
          "classTerm": "开课学期：xxx年x学期"
        },
        {
          "classId": "班级编号",
          "courseName": "课程名称",
          "classTerm": "开课学期：xxx年x学期"
        }
      ]
    }
  },
  '/scoreManagement/score/gpa': {
    isMock: true,
    code: 0,
    msg: 'foo error',
    data: {
      '2012-2013秋冬': 4.2,
      '2012-2013春夏': 4.7,
      '2013-2014秋冬': 1.5,
      '2013-2014春夏': 2.5,
      '2014-2015秋冬': 5,
      '2014-2015春夏': 4
    }
  }
}

var API = window.API = {
  frontURL: 'http://se.hlyue.com/front',
  baseURL: 'http://se.hlyue.com/index.php',

  /**
   * get data from API
   * @param path [string]
   * @param params [object, optional]
   * @param callback [function]
   */
  get: function(path, params, callback) {
    if (typeof params == 'function') {
      callback = params
      params = {}
    }
    if (MockObject[path] && MockObject[path].isMock) {
      API.__responseHandler(MockObject[path], callback)
    }
    else {
      path = API.baseURL + path
      $.getJSON(path, params, function(res) {
        API.__responseHandler(res, callback)
      })
    }
  },

  /**
   * post data to API
   * @param path [string]
   * @param params [object]
   * @param callback [function]
   */
  post: function(path, params, callback) {
    if (typeof params == 'function') {
      callback = params
      params = {}
    }
    if (MockObject[path] && MockObject[path].isMock) {
      API.__responseHandler(MockObject[path], callback)
    }
    else {
      path = API.baseURL + path
      $.post(path, params, function(res) {
        API.__responseHandler(res, callback)
      })
    }
  },

  /**
   * handle response
   * @param res [object]
   * @param callback [function]
   * @private
   */
  __responseHandler: function(res, callback) {
    if (res.code == 0) {
      if (typeof callback == 'function') callback(res.data)
    }
    else API.__errorHandler(res.code, res.msg)
  },

  /**
   * handle error
   * @param code [number]
   * @param msg [string]
   * @private
   */
  __errorHandler: function(code, msg) {
    alert('Data error: ' + msg)
  }
}