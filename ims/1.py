import random


cd={
  "college": {
    "计算机学院": {
      "department": [
        "计算机科学与技术",
        "软件工程"
      ]
    },
    "理学院": {
      "department": [
        "数学系",
        "物理系"
      ]
    },
    "经济学院": {
      "department": [
        "金融学",
        "财政学",
        "国际经济与贸易"
      ]
    },
    "法学院": {
      "department": [
        "法学"
      ]
    },
    "教育学院": {
      "department": [
        "教育学",
        "公共事业管理",
        "运动训练",
        "体育产业管理"
      ]
    },
    "人文学院": {
      "department": [
        "编辑出版学",
        "汉语言文学",
        "古典文献",
        "历史学",
        "美术学",
        "博物馆学",
        "艺术设计",
        "哲学"
      ]
    },
    "外国语言文化与国际交流学院": {
      "department": [
        "日语",
        "英语",
        "俄语",
        "翻译",
        "法语"
      ]
    },
    "生命科学学院": {
      "department": [
        "生物科学",
        "生物信息学",
        "生物技术"
      ]
    },
    "电器工程学院": {
      "department": [
        "自动化（电气学院）",
        "电子信息工程（电气学院）",
        "电气工程及其自动化"
        ]
    },
    "建筑工程学院": {
      "department": [
        "土木工程",
        "建筑学",
        "城乡规划"
        ]
    },
    "生物系统工程与食品科学学院": {
      "department": [
        "食品科学与工程",
        "生物工程"
      ]
    },
    "环境与资源学院": {
      "department": [
        "环境科学",
        "环境工程",
        "农业资源与环境"
      ]
    },
    "生物医学工程与仪器科学学院": {
      "department": [
        "生物医学工程",
        "测控技术与仪器"
      ]
    },
    "动物科学学院": {
      "department": [
        "动物科学",
        "动物医学"
      ]
    },
    "医学院": {
      "department": [
        "临床医学",
        "口腔医学",
        "预防医学"
      ]
    },
    "管理学院": {
      "department": [
        "信息管理与信息系统",
        "人力资源管理",
        "旅游管理",
        "农林经济管理",
        "财务管理",
        "会计学",
        "物流管理",
        "市场营销"
      ]
    },
    "计算机科学与技术学院": {
      "department": [
        "工业设计",
        "计算机科学与技术",
        "数字媒体技术",
        "产品设计"
      ]
    },
    "软件学院": {
      "department": [
        "软件工程"
      ]
    }
  }
}



if __name__=='__main__':
	typ=int(input('1.stu; 2.teacher; 3.course;'))
	num=int(input("batch input number:"))
	baseId=int(input('base id:'))
	l=[]
	c=list(cd['college'].keys())
	tableHead1=['uid','name','sex','college','department','grade','class']
	tableHead2=['uid','name','sex','college','department']
	tableHead3=['cid','name','ctype','college','department','credit','semester']
	for i in range(num):
		tmp1=c[random.randint(0,len(c)-1)]
		tmp2=cd['college'][tmp1]['department'][0]
		if typ==1:
			tableValue=[str(baseId+i),str(baseId+i),random.randint(0,1),tmp1,tmp2,random.randint(1,4),random.randint(1,6)]
			tmp=dict((a,b) for a,b in zip(tableHead1,tableValue))
		elif typ==2:
			tableValue=[str(baseId+i),str(baseId+i),random.randint(0,1),tmp1,tmp2]
			tmp=dict((a,b) for a,b in zip(tableHead2,tableValue))
		elif typ==3:
			tableValue=[str(baseId+i),str(baseId+i),random.randint(1,2),tmp1,tmp2,random.randint(1,4),random.randint(1,2)]
			tmp=dict((a,b) for a,b in zip(tableHead3,tableValue))
		l.append(tmp)
	print(l)
