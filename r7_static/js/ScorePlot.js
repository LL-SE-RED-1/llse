/**
 * Created by imsun on 6/11/15.
 */
var ScorePlot = window.ScorePlot = {
  /**
   * fill a SVG element with score plot
   * @param selector [string] document selector of target element
   * @param width [number]
   * @param height [number]
   * @param scoreData [object]
   * @returns {*}
   */
  fill: function(selector, width, height, scoreData) {
    var horizontalPadding = 40
    var verticalPadding = 20
    var innerWidth = width - horizontalPadding * 2
    var innerHeight = height - verticalPadding * 2
    var plot = d3.select(selector)
      .attr('class', 'score-plot')
      .attr('width', width)
      .attr('height', height)

    /**
     * preprocess score data
     */
    var scoreInfo = []
    for (var i = 0; i < 9; i++) {
      scoreInfo[i] = []
    }
    scoreData.forEach(function(score) {
      var range = Math.ceil((score.score - 59.99) / 5)
      range = range < 0 ? 0 :
        range > 8 ? 8 : range
      scoreInfo[range].push(score)
    })
    var maxRange = Math.max.apply(this, scoreInfo.map(function(scores) {
      return scores.length / scoreData.length * 100
    }))

    /**
     * draw axis
     */
    var xScale = d3.scale.linear()
      .domain([0, scoreInfo.length])
      .range([horizontalPadding, width - horizontalPadding])
    var xAxis = d3.svg.axis()
      .scale(xScale)
      .orient('bottom')
      .tickFormat(function(data) {
        if (data == scoreInfo.length) return '100 成绩'
        if (data > 0) return data * 5 + 55
        else return 0
      })
    var yScale = d3.scale.linear()
      .domain([maxRange, 0])
      .range([verticalPadding, height - verticalPadding])
    var yAxis = d3.svg.axis()
      .scale(yScale)
      .orient('left')
      .tickFormat(function(data) {
        if (data === 0) return ''
        return data + '%'
      })

    plot.append('g')
      .attr('class', 'axis')
      .attr('transform', 'translate(0, ' + (height - verticalPadding) + ')')
      .call(xAxis)
    plot.append('g')
      .attr('class', 'axis')
      .attr('transform', 'translate(' + (horizontalPadding - 1) + ', 0)')
      .call(yAxis)

    /**
     * draw bar
     */
    plot.selectAll('rect')
      .data(scoreInfo)
      .enter()
      .append('rect')
      .attr('class', 'score-plot-bar')
      .attr('x', function(data, index) {
        return xScale(index)
      })
      .attr('y', function(data) {
        return yScale(data.length / scoreData.length * 100)
      })
      .attr('width', innerWidth / scoreInfo.length)
      .attr('height', function(data) {
        return innerHeight - yScale(data.length / scoreData.length * 100) + verticalPadding
      })

    return plot
  }
}

var GpaPlot = window.GpaPlot = {
  fill: function(selector, width, height, gpaData) {
    var horizontalPadding = 40
    var verticalPadding = 20
    var innerWidth = width - horizontalPadding * 2
    var innerHeight = height - verticalPadding * 2

    var terms = Object.keys(gpaData)
    var gpas = terms.map(function(term) {
      return gpaData[term]
    })
    var gpaArray = terms.map(function(term) {
      return {
        term: term,
        gpa: gpaData[term]
      }
    })

    var plot = d3.select(selector)
      .attr('class', 'gpa-plot')
      .attr('width', width)
      .attr('height', height)

    /**
     * draw axis
     */
    var xScale = d3.scale.linear()
      .domain([0, terms.length - 1])
      .range([horizontalPadding, width - horizontalPadding])
    var xAxis = d3.svg.axis()
      .scale(xScale)
      .orient('bottom')
      .ticks(terms.length)
      .tickFormat(function(data) {
        return terms[data]
      })
    var yScale = d3.scale.linear()
      .domain([5, 0])
      .range([verticalPadding, height - verticalPadding])
    var yAxis = d3.svg.axis()
      .scale(yScale)
      .orient('left')

    plot.append('g')
      .attr('class', 'axis')
      .attr('transform', 'translate(0, ' + (height - verticalPadding) + ')')
      .call(xAxis)
    plot.append('g')
      .attr('class', 'axis')
      .attr('transform', 'translate(' + (horizontalPadding - 1) + ', 0)')
      .call(yAxis)

    /**
     * draw circles
     */
    plot.selectAll('circle')
      .data(gpaArray)
      .enter()
      .append('circle')
      .attr('r', 5)
      .attr('cx', function(data, index) {
        return xScale(index)
      })
      .attr('cy', function(data) {
        return yScale(data.gpa)
      })

    var line = d3.svg.line()
      .x(function(data, index) {
        return xScale(index)
      })
      .y(function(data) {
        return yScale(data.gpa)
      })
      //.interpolate('monotone')
    plot.append('path')
      .attr('class', 'line')
      .attr('d', line(gpaArray))

  }
}
