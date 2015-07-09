<html>
<h2>查询结果</h2>
<h3>本次考试参与人数:<?php echo count($sc) ?></h3>
	<?php /*ksort($ans); */ //按题号排序?>
	<h3>错题分析: </h3><!--显示错题分析表格-->
	<table border=1>
	<tr>
		<th>题目ID</th>
		<th>类型</th>
		<th>难度</th>
		<th>测试单元</th>
		<th>错误率</th>
	</tr>
	<?php
	$data_diagram2 = array('单元0'=>0,'单元1'=>0,'单元2'=>0,'单元3'=>0,'单元4'=>0,'单元5'=>0,'单元6'=>0,'单元7'=>0,'单元8'=>0,'单元9'=>0,);
	$data_diagram3 = array();
	for($i=0;$i<count($ans);$i++)
	{
		//$x_value = $x_value*100/count($sc);//数据显示为百分百
		$x_value = number_format($ans[$i][4]/count($sc)*100,2);//保留小数点2位
		echo '<tr>
		<td>'.$ans[$i][0].'</td>';
		echo '<td>'.$ans[$i][1].'</td>';
		echo '<td>'.$ans[$i][2].'</td>';
		echo '<td>'.$ans[$i][3].'</td>';
		echo '<td>'.$x_value.'</td>
		</tr>';
		$mytemp='单元'.$ans[$i][3];
		$data_diagram2[$mytemp]++;
		$mytemp=$ans[$i][4]/count($sc);
		$data_diagram3+=array($ans[$i][0]=>$mytemp);
	}
	echo '</table>';
	
	$diagram2  ="var csvdata2= \"age,population";
	foreach($data_diagram2 as $unit=>$num){
		if($num>0){
			$diagram2=$diagram2."\\n$unit,$num";
		}
	}
	$diagram2=$diagram2."\";";
	arsort($data_diagram3);
	$diagram3 = "var csvdata3= \"letter,frequency";
	foreach($data_diagram3 as $id=>$rate){
		$diagram3=$diagram3."\\n$id,$rate";
	}
	$diagram3=$diagram3."\";";
	
	//显示学生的分数分布情况
	//$diagram1 ="var csvdata= \"letter,frequency\\nA,0.1\\nB,0.1\";";
	$diagram1  ="var csvdata= \"letter,frequency";
	$sscore=array('90-100'=>0,'80-89'=>0,'70-79'=>0,'60-69'=>0,
			'不及格'=>0);
	foreach($sc as $score1)
	{
		$score=$score1['Score'];
		//统计各个分数段的学生人数
		if($score<60)
			$sscore['不及格']++;
		else if($score<70)
			$sscore['60-69']++;
		else if($score<80)
			$sscore['70-79']++;
		else if($score<90)
			$sscore['80-89']++;
		else 
		{
			$sscore['90-100']++;
		}
	}
	$temp = count($sc);
	//echo $temp;
	foreach ($sscore as $x=>$x_value)//列出分数表格
	{	
		$temp2= $x_value/$temp;
		$diagram1 = $diagram1."\\n$x,$temp2";
	}
	$diagram1=$diagram1."\";";
	/*
	echo '<br>分数分布情况:<br>
	<table border=1>
	<tr>
	<th>分数</th>
	<th>人数</th>
	</tr>';
	foreach ($sscore as $x=>$x_value)//列出分数表格
	{
		echo '<tr>
		<td>'.$x.'</td>';
		echo '<td>'.$x_value.'</td>
		</tr>';
	}
	echo '</table>';*/
?>
<meta charset="utf-8">
<style>

    .bar {
        fill: steelblue;
    }

    .bar:hover {
        fill: brown;
    }

    .axis {
        font: 10px sans-serif;
    }

    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }

    .x.axis path {
        display: none;
    }

</style>
<body>
<h3>成绩分布：</h3>
<div id="grade_svg"></div>
<script src="<?php echo base_url();?>/js/d3.min.js"></script>
<script>

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1);

    var y = d3.scale.linear()
        .range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");
	
    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .ticks(10, "%");

    var svg = d3.select("#grade_svg").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
	</script>
	<h3>错题分布：</h3>
	<div id="error_svg"></div>
	<script>
	<?php echo $diagram1 ?>
    var data = d3.csv.parse(csvdata);

        x.domain(data.map(function(d) { return d.letter; }));
        y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 6)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("占总人数百分百");

        svg.selectAll(".bar")
            .data(data)
            .enter().append("rect")
            .attr("class", "bar")
            .attr("x", function(d) { return x(d.letter); })
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.frequency); })
            .attr("height", function(d) { return height - y(d.frequency); });

    function type(d) {
        d.frequency = +d.frequency;
        return d;
    }
	
	
	
	
	
	<?php echo $diagram3 ?>
	
	var svg = d3.select("#error_svg").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
    var data = d3.csv.parse(csvdata3);

        x.domain(data.map(function(d) { return d.letter; }));
        y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 6)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("错误率");

        svg.selectAll(".bar")
            .data(data)
            .enter().append("rect")
            .attr("class", "bar")
            .attr("x", function(d) { return x(d.letter); })
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.frequency); })
            .attr("height", function(d) { return height - y(d.frequency); });

    
	
	</script>
	<h3>错题单元分布：</h3>
	<div id="unit_svg"></div>
	<script>
	
		
		
	var radius = Math.min(width, height) / 2;
	var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);
	
	var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56","#d0743c", "#ff8c00"]);

	var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

	var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.population; });
	
	var svg = d3.select("#unit_svg").append("svg")
    .attr("width", width)
    .attr("height", height)
	.append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
	<?php echo $diagram2?>
	
	var data = d3.csv.parse(csvdata2);
	//d3.csv("data.csv", function(error, data) {

		data.forEach(function(d) {
		d.population = +d.population;
		});

		var g = svg.selectAll(".arc")
		.data(pie(data))
		.enter().append("g")
		.attr("class", "arc");

		g.append("path")
		.attr("d", arc)
		.style("fill", function(d) { return color(d.data.age); });
	
		g.append("text")
		.attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
		.attr("dy", ".35em")
		.style("text-anchor", "middle")
		.text(function(d) { return d.data.age; });

	//});
</script>
</div>
</div>
</html>