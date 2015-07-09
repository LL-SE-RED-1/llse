/*
get hash param from current url
eg: www.abc.com/index.html#classId=1&ddd=2
    getHashParam('classId') : 1
    getHashParam('ddd') : 2
    getHashParam('dontknow') : undefined
 */
window.getHashParam = (function() {
  var hash, j, len, params, ref, str;
  params = [];
  hash = window.location.hash.substr(1);
  ref = hash.split('&');
  for (j = 0, len = ref.length; j < len; j++) {
    str = ref[j];
    params[decodeURIComponent(str.split('=')[0])] = decodeURIComponent(str.split('=')[1]);
  }
  return function(p) {
    return params[p];
  };
})();


/*
build url hash segment to pass params to another page
@param params should only be array or object
@return string with '#' for current hash of params
 */

window.buildHashUrl = function(params) {
  var hash, i, p;
  if (params == null) {
    return null;
  }
  hash = [];
  for (i in params) {
    p = params[i];
    hash.push(encodeURIComponent(i) + '=' + encodeURIComponent(p));
  }
  return '#' + hash.join('&');
};


/*
calculate grade based on score
@param score the score should be [0, 100]
@param isAbsent boolean
@return float of grade value
 */

window.calculateGrade = function(score, isAbsent) {
  score = parseInt(score);
  if (isAbsent === "true" || isAbsent === true) {
    return 0.0;
  }
  if (score >= 95) {
    return 5.0;
  }
  if (score < 60) {
    return 0.0;
  }
  return (score - 60) / 10.0 + 1.5;
};

/*
regularize the score
@param input score in any number
@return int of score, [0, 100]
 */

window.regularizeScore = function(score) {
  score = parseInt(score);
  
  if (score > 100) {
    return 100;
  }
  if (score < 0) {
    return 0;
  }
  return score;
};

