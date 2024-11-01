(()=>{"use strict";function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},t(e)}function e(t){if(null===t||!0===t||!1===t)return NaN;var e=Number(t);return isNaN(e)?e:e<0?Math.ceil(e):Math.floor(e)}function n(t,e){if(e.length<t)throw new TypeError(t+" argument"+(t>1?"s":"")+" required, but only "+e.length+" present")}function r(e){n(1,arguments);var r=Object.prototype.toString.call(e);return e instanceof Date||"object"===t(e)&&"[object Date]"===r?new Date(e.getTime()):"number"==typeof e||"[object Number]"===r?new Date(e):("string"!=typeof e&&"[object String]"!==r||"undefined"==typeof console||(console.warn("Starting with v2.0.0-beta.1 date-fns doesn't accept strings as date arguments. Please use `parseISO` to parse strings. See: https://github.com/date-fns/date-fns/blob/master/docs/upgradeGuide.md#string-arguments"),console.warn((new Error).stack)),new Date(NaN))}function a(t){n(1,arguments);var e=r(t),a=e.getUTCDay(),o=(a<1?7:0)+a-1;return e.setUTCDate(e.getUTCDate()-o),e.setUTCHours(0,0,0,0),e}function o(t){n(1,arguments);var e=r(t),o=e.getUTCFullYear(),i=new Date(0);i.setUTCFullYear(o+1,0,4),i.setUTCHours(0,0,0,0);var u=a(i),d=new Date(0);d.setUTCFullYear(o,0,4),d.setUTCHours(0,0,0,0);var s=a(d);return e.getTime()>=u.getTime()?o+1:e.getTime()>=s.getTime()?o:o-1}var i={};function u(){return i}function d(t,a){var o,i,d,s,l,c,h,f;n(1,arguments);var m=u(),g=e(null!==(o=null!==(i=null!==(d=null!==(s=null==a?void 0:a.weekStartsOn)&&void 0!==s?s:null==a||null===(l=a.locale)||void 0===l||null===(c=l.options)||void 0===c?void 0:c.weekStartsOn)&&void 0!==d?d:m.weekStartsOn)&&void 0!==i?i:null===(h=m.locale)||void 0===h||null===(f=h.options)||void 0===f?void 0:f.weekStartsOn)&&void 0!==o?o:0);if(!(g>=0&&g<=6))throw new RangeError("weekStartsOn must be between 0 and 6 inclusively");var v=r(t),w=v.getUTCDay(),b=(w<g?7:0)+w-g;return v.setUTCDate(v.getUTCDate()-b),v.setUTCHours(0,0,0,0),v}function s(t,a){var o,i,s,l,c,h,f,m;n(1,arguments);var g=r(t),v=g.getUTCFullYear(),w=u(),b=e(null!==(o=null!==(i=null!==(s=null!==(l=null==a?void 0:a.firstWeekContainsDate)&&void 0!==l?l:null==a||null===(c=a.locale)||void 0===c||null===(h=c.options)||void 0===h?void 0:h.firstWeekContainsDate)&&void 0!==s?s:w.firstWeekContainsDate)&&void 0!==i?i:null===(f=w.locale)||void 0===f||null===(m=f.options)||void 0===m?void 0:m.firstWeekContainsDate)&&void 0!==o?o:1);if(!(b>=1&&b<=7))throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively");var y=new Date(0);y.setUTCFullYear(v+1,0,b),y.setUTCHours(0,0,0,0);var p=d(y,a),T=new Date(0);T.setUTCFullYear(v,0,b),T.setUTCHours(0,0,0,0);var M=d(T,a);return g.getTime()>=p.getTime()?v+1:g.getTime()>=M.getTime()?v:v-1}function l(t,e){for(var n=t<0?"-":"",r=Math.abs(t).toString();r.length<e;)r="0"+r;return n+r}const c=function(t,e){var n=t.getUTCFullYear(),r=n>0?n:1-n;return l("yy"===e?r%100:r,e.length)},h=function(t,e){var n=t.getUTCMonth();return"M"===e?String(n+1):l(n+1,2)},f=function(t,e){return l(t.getUTCDate(),e.length)},m=function(t,e){return l(t.getUTCHours()%12||12,e.length)},g=function(t,e){return l(t.getUTCHours(),e.length)},v=function(t,e){return l(t.getUTCMinutes(),e.length)},w=function(t,e){return l(t.getUTCSeconds(),e.length)},b=function(t,e){var n=e.length,r=t.getUTCMilliseconds();return l(Math.floor(r*Math.pow(10,n-3)),e.length)};var y={G:function(t,e,n){var r=t.getUTCFullYear()>0?1:0;switch(e){case"G":case"GG":case"GGG":return n.era(r,{width:"abbreviated"});case"GGGGG":return n.era(r,{width:"narrow"});default:return n.era(r,{width:"wide"})}},y:function(t,e,n){if("yo"===e){var r=t.getUTCFullYear(),a=r>0?r:1-r;return n.ordinalNumber(a,{unit:"year"})}return c(t,e)},Y:function(t,e,n,r){var a=s(t,r),o=a>0?a:1-a;return"YY"===e?l(o%100,2):"Yo"===e?n.ordinalNumber(o,{unit:"year"}):l(o,e.length)},R:function(t,e){return l(o(t),e.length)},u:function(t,e){return l(t.getUTCFullYear(),e.length)},Q:function(t,e,n){var r=Math.ceil((t.getUTCMonth()+1)/3);switch(e){case"Q":return String(r);case"QQ":return l(r,2);case"Qo":return n.ordinalNumber(r,{unit:"quarter"});case"QQQ":return n.quarter(r,{width:"abbreviated",context:"formatting"});case"QQQQQ":return n.quarter(r,{width:"narrow",context:"formatting"});default:return n.quarter(r,{width:"wide",context:"formatting"})}},q:function(t,e,n){var r=Math.ceil((t.getUTCMonth()+1)/3);switch(e){case"q":return String(r);case"qq":return l(r,2);case"qo":return n.ordinalNumber(r,{unit:"quarter"});case"qqq":return n.quarter(r,{width:"abbreviated",context:"standalone"});case"qqqqq":return n.quarter(r,{width:"narrow",context:"standalone"});default:return n.quarter(r,{width:"wide",context:"standalone"})}},M:function(t,e,n){var r=t.getUTCMonth();switch(e){case"M":case"MM":return h(t,e);case"Mo":return n.ordinalNumber(r+1,{unit:"month"});case"MMM":return n.month(r,{width:"abbreviated",context:"formatting"});case"MMMMM":return n.month(r,{width:"narrow",context:"formatting"});default:return n.month(r,{width:"wide",context:"formatting"})}},L:function(t,e,n){var r=t.getUTCMonth();switch(e){case"L":return String(r+1);case"LL":return l(r+1,2);case"Lo":return n.ordinalNumber(r+1,{unit:"month"});case"LLL":return n.month(r,{width:"abbreviated",context:"standalone"});case"LLLLL":return n.month(r,{width:"narrow",context:"standalone"});default:return n.month(r,{width:"wide",context:"standalone"})}},w:function(t,a,o,i){var c=function(t,a){n(1,arguments);var o=r(t),i=d(o,a).getTime()-function(t,r){var a,o,i,l,c,h,f,m;n(1,arguments);var g=u(),v=e(null!==(a=null!==(o=null!==(i=null!==(l=null==r?void 0:r.firstWeekContainsDate)&&void 0!==l?l:null==r||null===(c=r.locale)||void 0===c||null===(h=c.options)||void 0===h?void 0:h.firstWeekContainsDate)&&void 0!==i?i:g.firstWeekContainsDate)&&void 0!==o?o:null===(f=g.locale)||void 0===f||null===(m=f.options)||void 0===m?void 0:m.firstWeekContainsDate)&&void 0!==a?a:1),w=s(t,r),b=new Date(0);return b.setUTCFullYear(w,0,v),b.setUTCHours(0,0,0,0),d(b,r)}(o,a).getTime();return Math.round(i/6048e5)+1}(t,i);return"wo"===a?o.ordinalNumber(c,{unit:"week"}):l(c,a.length)},I:function(t,e,i){var u=function(t){n(1,arguments);var e=r(t),i=a(e).getTime()-function(t){n(1,arguments);var e=o(t),r=new Date(0);return r.setUTCFullYear(e,0,4),r.setUTCHours(0,0,0,0),a(r)}(e).getTime();return Math.round(i/6048e5)+1}(t);return"Io"===e?i.ordinalNumber(u,{unit:"week"}):l(u,e.length)},d:function(t,e,n){return"do"===e?n.ordinalNumber(t.getUTCDate(),{unit:"date"}):f(t,e)},D:function(t,e,a){var o=function(t){n(1,arguments);var e=r(t),a=e.getTime();e.setUTCMonth(0,1),e.setUTCHours(0,0,0,0);var o=a-e.getTime();return Math.floor(o/864e5)+1}(t);return"Do"===e?a.ordinalNumber(o,{unit:"dayOfYear"}):l(o,e.length)},E:function(t,e,n){var r=t.getUTCDay();switch(e){case"E":case"EE":case"EEE":return n.day(r,{width:"abbreviated",context:"formatting"});case"EEEEE":return n.day(r,{width:"narrow",context:"formatting"});case"EEEEEE":return n.day(r,{width:"short",context:"formatting"});default:return n.day(r,{width:"wide",context:"formatting"})}},e:function(t,e,n,r){var a=t.getUTCDay(),o=(a-r.weekStartsOn+8)%7||7;switch(e){case"e":return String(o);case"ee":return l(o,2);case"eo":return n.ordinalNumber(o,{unit:"day"});case"eee":return n.day(a,{width:"abbreviated",context:"formatting"});case"eeeee":return n.day(a,{width:"narrow",context:"formatting"});case"eeeeee":return n.day(a,{width:"short",context:"formatting"});default:return n.day(a,{width:"wide",context:"formatting"})}},c:function(t,e,n,r){var a=t.getUTCDay(),o=(a-r.weekStartsOn+8)%7||7;switch(e){case"c":return String(o);case"cc":return l(o,e.length);case"co":return n.ordinalNumber(o,{unit:"day"});case"ccc":return n.day(a,{width:"abbreviated",context:"standalone"});case"ccccc":return n.day(a,{width:"narrow",context:"standalone"});case"cccccc":return n.day(a,{width:"short",context:"standalone"});default:return n.day(a,{width:"wide",context:"standalone"})}},i:function(t,e,n){var r=t.getUTCDay(),a=0===r?7:r;switch(e){case"i":return String(a);case"ii":return l(a,e.length);case"io":return n.ordinalNumber(a,{unit:"day"});case"iii":return n.day(r,{width:"abbreviated",context:"formatting"});case"iiiii":return n.day(r,{width:"narrow",context:"formatting"});case"iiiiii":return n.day(r,{width:"short",context:"formatting"});default:return n.day(r,{width:"wide",context:"formatting"})}},a:function(t,e,n){var r=t.getUTCHours()/12>=1?"pm":"am";switch(e){case"a":case"aa":return n.dayPeriod(r,{width:"abbreviated",context:"formatting"});case"aaa":return n.dayPeriod(r,{width:"abbreviated",context:"formatting"}).toLowerCase();case"aaaaa":return n.dayPeriod(r,{width:"narrow",context:"formatting"});default:return n.dayPeriod(r,{width:"wide",context:"formatting"})}},b:function(t,e,n){var r,a=t.getUTCHours();switch(r=12===a?"noon":0===a?"midnight":a/12>=1?"pm":"am",e){case"b":case"bb":return n.dayPeriod(r,{width:"abbreviated",context:"formatting"});case"bbb":return n.dayPeriod(r,{width:"abbreviated",context:"formatting"}).toLowerCase();case"bbbbb":return n.dayPeriod(r,{width:"narrow",context:"formatting"});default:return n.dayPeriod(r,{width:"wide",context:"formatting"})}},B:function(t,e,n){var r,a=t.getUTCHours();switch(r=a>=17?"evening":a>=12?"afternoon":a>=4?"morning":"night",e){case"B":case"BB":case"BBB":return n.dayPeriod(r,{width:"abbreviated",context:"formatting"});case"BBBBB":return n.dayPeriod(r,{width:"narrow",context:"formatting"});default:return n.dayPeriod(r,{width:"wide",context:"formatting"})}},h:function(t,e,n){if("ho"===e){var r=t.getUTCHours()%12;return 0===r&&(r=12),n.ordinalNumber(r,{unit:"hour"})}return m(t,e)},H:function(t,e,n){return"Ho"===e?n.ordinalNumber(t.getUTCHours(),{unit:"hour"}):g(t,e)},K:function(t,e,n){var r=t.getUTCHours()%12;return"Ko"===e?n.ordinalNumber(r,{unit:"hour"}):l(r,e.length)},k:function(t,e,n){var r=t.getUTCHours();return 0===r&&(r=24),"ko"===e?n.ordinalNumber(r,{unit:"hour"}):l(r,e.length)},m:function(t,e,n){return"mo"===e?n.ordinalNumber(t.getUTCMinutes(),{unit:"minute"}):v(t,e)},s:function(t,e,n){return"so"===e?n.ordinalNumber(t.getUTCSeconds(),{unit:"second"}):w(t,e)},S:function(t,e){return b(t,e)},X:function(t,e,n,r){var a=(r._originalDate||t).getTimezoneOffset();if(0===a)return"Z";switch(e){case"X":return T(a);case"XXXX":case"XX":return M(a);default:return M(a,":")}},x:function(t,e,n,r){var a=(r._originalDate||t).getTimezoneOffset();switch(e){case"x":return T(a);case"xxxx":case"xx":return M(a);default:return M(a,":")}},O:function(t,e,n,r){var a=(r._originalDate||t).getTimezoneOffset();switch(e){case"O":case"OO":case"OOO":return"GMT"+p(a,":");default:return"GMT"+M(a,":")}},z:function(t,e,n,r){var a=(r._originalDate||t).getTimezoneOffset();switch(e){case"z":case"zz":case"zzz":return"GMT"+p(a,":");default:return"GMT"+M(a,":")}},t:function(t,e,n,r){var a=r._originalDate||t;return l(Math.floor(a.getTime()/1e3),e.length)},T:function(t,e,n,r){return l((r._originalDate||t).getTime(),e.length)}};function p(t,e){var n=t>0?"-":"+",r=Math.abs(t),a=Math.floor(r/60),o=r%60;if(0===o)return n+String(a);var i=e||"";return n+String(a)+i+l(o,2)}function T(t,e){return t%60==0?(t>0?"-":"+")+l(Math.abs(t)/60,2):M(t,e)}function M(t,e){var n=e||"",r=t>0?"-":"+",a=Math.abs(t);return r+l(Math.floor(a/60),2)+n+l(a%60,2)}const C=y;var D=function(t,e){switch(t){case"P":return e.date({width:"short"});case"PP":return e.date({width:"medium"});case"PPP":return e.date({width:"long"});default:return e.date({width:"full"})}},k=function(t,e){switch(t){case"p":return e.time({width:"short"});case"pp":return e.time({width:"medium"});case"ppp":return e.time({width:"long"});default:return e.time({width:"full"})}},S={p:k,P:function(t,e){var n,r=t.match(/(P+)(p+)?/)||[],a=r[1],o=r[2];if(!o)return D(t,e);switch(a){case"P":n=e.dateTime({width:"short"});break;case"PP":n=e.dateTime({width:"medium"});break;case"PPP":n=e.dateTime({width:"long"});break;default:n=e.dateTime({width:"full"})}return n.replace("{{date}}",D(a,e)).replace("{{time}}",k(o,e))}};const x=S;var U=["D","DD"],P=["YY","YYYY"];function W(t,e,n){if("YYYY"===t)throw new RangeError("Use `yyyy` instead of `YYYY` (in `".concat(e,"`) for formatting years to the input `").concat(n,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if("YY"===t)throw new RangeError("Use `yy` instead of `YY` (in `".concat(e,"`) for formatting years to the input `").concat(n,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if("D"===t)throw new RangeError("Use `d` instead of `D` (in `".concat(e,"`) for formatting days of the month to the input `").concat(n,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"));if("DD"===t)throw new RangeError("Use `dd` instead of `DD` (in `".concat(e,"`) for formatting days of the month to the input `").concat(n,"`; see: https://github.com/date-fns/date-fns/blob/master/docs/unicodeTokens.md"))}var Y={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXWeeks:{one:"about 1 week",other:"about {{count}} weeks"},xWeeks:{one:"1 week",other:"{{count}} weeks"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};function N(t){return function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n=e.width?String(e.width):t.defaultWidth;return t.formats[n]||t.formats[t.defaultWidth]}}var E,O={date:N({formats:{full:"EEEE, MMMM do, y",long:"MMMM do, y",medium:"MMM d, y",short:"MM/dd/yyyy"},defaultWidth:"full"}),time:N({formats:{full:"h:mm:ss a zzzz",long:"h:mm:ss a z",medium:"h:mm:ss a",short:"h:mm a"},defaultWidth:"full"}),dateTime:N({formats:{full:"{{date}} 'at' {{time}}",long:"{{date}} 'at' {{time}}",medium:"{{date}}, {{time}}",short:"{{date}}, {{time}}"},defaultWidth:"full"})},q={lastWeek:"'last' eeee 'at' p",yesterday:"'yesterday at' p",today:"'today at' p",tomorrow:"'tomorrow at' p",nextWeek:"eeee 'at' p",other:"P"};function j(t){return function(e,n){var r;if("formatting"===(null!=n&&n.context?String(n.context):"standalone")&&t.formattingValues){var a=t.defaultFormattingWidth||t.defaultWidth,o=null!=n&&n.width?String(n.width):a;r=t.formattingValues[o]||t.formattingValues[a]}else{var i=t.defaultWidth,u=null!=n&&n.width?String(n.width):t.defaultWidth;r=t.values[u]||t.values[i]}return r[t.argumentCallback?t.argumentCallback(e):e]}}function F(t){return function(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=n.width,a=r&&t.matchPatterns[r]||t.matchPatterns[t.defaultMatchWidth],o=e.match(a);if(!o)return null;var i,u=o[0],d=r&&t.parsePatterns[r]||t.parsePatterns[t.defaultParseWidth],s=Array.isArray(d)?function(t,e){for(var n=0;n<t.length;n++)if(t[n].test(u))return n}(d):function(t,e){for(var n in t)if(t.hasOwnProperty(n)&&t[n].test(u))return n}(d);return i=t.valueCallback?t.valueCallback(s):s,{value:i=n.valueCallback?n.valueCallback(i):i,rest:e.slice(u.length)}}}const H={code:"en-US",formatDistance:function(t,e,n){var r,a=Y[t];return r="string"==typeof a?a:1===e?a.one:a.other.replace("{{count}}",e.toString()),null!=n&&n.addSuffix?n.comparison&&n.comparison>0?"in "+r:r+" ago":r},formatLong:O,formatRelative:function(t,e,n,r){return q[t]},localize:{ordinalNumber:function(t,e){var n=Number(t),r=n%100;if(r>20||r<10)switch(r%10){case 1:return n+"st";case 2:return n+"nd";case 3:return n+"rd"}return n+"th"},era:j({values:{narrow:["B","A"],abbreviated:["BC","AD"],wide:["Before Christ","Anno Domini"]},defaultWidth:"wide"}),quarter:j({values:{narrow:["1","2","3","4"],abbreviated:["Q1","Q2","Q3","Q4"],wide:["1st quarter","2nd quarter","3rd quarter","4th quarter"]},defaultWidth:"wide",argumentCallback:function(t){return t-1}}),month:j({values:{narrow:["J","F","M","A","M","J","J","A","S","O","N","D"],abbreviated:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],wide:["January","February","March","April","May","June","July","August","September","October","November","December"]},defaultWidth:"wide"}),day:j({values:{narrow:["S","M","T","W","T","F","S"],short:["Su","Mo","Tu","We","Th","Fr","Sa"],abbreviated:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],wide:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},defaultWidth:"wide"}),dayPeriod:j({values:{narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"morning",afternoon:"afternoon",evening:"evening",night:"night"}},defaultWidth:"wide",formattingValues:{narrow:{am:"a",pm:"p",midnight:"mi",noon:"n",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},abbreviated:{am:"AM",pm:"PM",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"},wide:{am:"a.m.",pm:"p.m.",midnight:"midnight",noon:"noon",morning:"in the morning",afternoon:"in the afternoon",evening:"in the evening",night:"at night"}},defaultFormattingWidth:"wide"})},match:{ordinalNumber:(E={matchPattern:/^(\d+)(th|st|nd|rd)?/i,parsePattern:/\d+/i,valueCallback:function(t){return parseInt(t,10)}},function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=t.match(E.matchPattern);if(!n)return null;var r=n[0],a=t.match(E.parsePattern);if(!a)return null;var o=E.valueCallback?E.valueCallback(a[0]):a[0];return{value:o=e.valueCallback?e.valueCallback(o):o,rest:t.slice(r.length)}}),era:F({matchPatterns:{narrow:/^(b|a)/i,abbreviated:/^(b\.?\s?c\.?|b\.?\s?c\.?\s?e\.?|a\.?\s?d\.?|c\.?\s?e\.?)/i,wide:/^(before christ|before common era|anno domini|common era)/i},defaultMatchWidth:"wide",parsePatterns:{any:[/^b/i,/^(a|c)/i]},defaultParseWidth:"any"}),quarter:F({matchPatterns:{narrow:/^[1234]/i,abbreviated:/^q[1234]/i,wide:/^[1234](th|st|nd|rd)? quarter/i},defaultMatchWidth:"wide",parsePatterns:{any:[/1/i,/2/i,/3/i,/4/i]},defaultParseWidth:"any",valueCallback:function(t){return t+1}}),month:F({matchPatterns:{narrow:/^[jfmasond]/i,abbreviated:/^(jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec)/i,wide:/^(january|february|march|april|may|june|july|august|september|october|november|december)/i},defaultMatchWidth:"wide",parsePatterns:{narrow:[/^j/i,/^f/i,/^m/i,/^a/i,/^m/i,/^j/i,/^j/i,/^a/i,/^s/i,/^o/i,/^n/i,/^d/i],any:[/^ja/i,/^f/i,/^mar/i,/^ap/i,/^may/i,/^jun/i,/^jul/i,/^au/i,/^s/i,/^o/i,/^n/i,/^d/i]},defaultParseWidth:"any"}),day:F({matchPatterns:{narrow:/^[smtwf]/i,short:/^(su|mo|tu|we|th|fr|sa)/i,abbreviated:/^(sun|mon|tue|wed|thu|fri|sat)/i,wide:/^(sunday|monday|tuesday|wednesday|thursday|friday|saturday)/i},defaultMatchWidth:"wide",parsePatterns:{narrow:[/^s/i,/^m/i,/^t/i,/^w/i,/^t/i,/^f/i,/^s/i],any:[/^su/i,/^m/i,/^tu/i,/^w/i,/^th/i,/^f/i,/^sa/i]},defaultParseWidth:"any"}),dayPeriod:F({matchPatterns:{narrow:/^(a|p|mi|n|(in the|at) (morning|afternoon|evening|night))/i,any:/^([ap]\.?\s?m\.?|midnight|noon|(in the|at) (morning|afternoon|evening|night))/i},defaultMatchWidth:"any",parsePatterns:{any:{am:/^a/i,pm:/^p/i,midnight:/^mi/i,noon:/^no/i,morning:/morning/i,afternoon:/afternoon/i,evening:/evening/i,night:/night/i}},defaultParseWidth:"any"})},options:{weekStartsOn:0,firstWeekContainsDate:1}};var L=/[yYQqMLwIdDecihHKkms]o|(\w)\1*|''|'(''|[^'])+('|$)|./g,z=/P+p+|P+|p+|''|'(''|[^'])+('|$)|./g,G=/^'([^]*?)'?$/,Q=/''/g,A=/[a-zA-Z]/;function B(a,o,i){var d,s,l,c,h,f,m,g,v,w,b,y,p,T,M,D,k,S;n(2,arguments);var Y=String(o),N=u(),E=null!==(d=null!==(s=null==i?void 0:i.locale)&&void 0!==s?s:N.locale)&&void 0!==d?d:H,O=e(null!==(l=null!==(c=null!==(h=null!==(f=null==i?void 0:i.firstWeekContainsDate)&&void 0!==f?f:null==i||null===(m=i.locale)||void 0===m||null===(g=m.options)||void 0===g?void 0:g.firstWeekContainsDate)&&void 0!==h?h:N.firstWeekContainsDate)&&void 0!==c?c:null===(v=N.locale)||void 0===v||null===(w=v.options)||void 0===w?void 0:w.firstWeekContainsDate)&&void 0!==l?l:1);if(!(O>=1&&O<=7))throw new RangeError("firstWeekContainsDate must be between 1 and 7 inclusively");var q=e(null!==(b=null!==(y=null!==(p=null!==(T=null==i?void 0:i.weekStartsOn)&&void 0!==T?T:null==i||null===(M=i.locale)||void 0===M||null===(D=M.options)||void 0===D?void 0:D.weekStartsOn)&&void 0!==p?p:N.weekStartsOn)&&void 0!==y?y:null===(k=N.locale)||void 0===k||null===(S=k.options)||void 0===S?void 0:S.weekStartsOn)&&void 0!==b?b:0);if(!(q>=0&&q<=6))throw new RangeError("weekStartsOn must be between 0 and 6 inclusively");if(!E.localize)throw new RangeError("locale must contain localize property");if(!E.formatLong)throw new RangeError("locale must contain formatLong property");var j=r(a);if(!function(e){if(n(1,arguments),!function(e){return n(1,arguments),e instanceof Date||"object"===t(e)&&"[object Date]"===Object.prototype.toString.call(e)}(e)&&"number"!=typeof e)return!1;var a=r(e);return!isNaN(Number(a))}(j))throw new RangeError("Invalid time value");var F=function(t){var e=new Date(Date.UTC(t.getFullYear(),t.getMonth(),t.getDate(),t.getHours(),t.getMinutes(),t.getSeconds(),t.getMilliseconds()));return e.setUTCFullYear(t.getFullYear()),t.getTime()-e.getTime()}(j),B=function(t,a){return n(2,arguments),function(t,a){n(2,arguments);var o=r(t).getTime(),i=e(a);return new Date(o+i)}(t,-e(a))}(j,F),X={firstWeekContainsDate:O,weekStartsOn:q,locale:E,_originalDate:j};return Y.match(z).map((function(t){var e=t[0];return"p"===e||"P"===e?(0,x[e])(t,E.formatLong):t})).join("").match(L).map((function(t){if("''"===t)return"'";var e,n,r=t[0];if("'"===r)return(n=(e=t).match(G))?n[1].replace(Q,"'"):e;var u,d=C[r];if(d)return null!=i&&i.useAdditionalWeekYearTokens||(u=t,-1===P.indexOf(u))||W(t,o,String(a)),null!=i&&i.useAdditionalDayOfYearTokens||!function(t){return-1!==U.indexOf(t)}(t)||W(t,o,String(a)),d(B,t,E.localize,X);if(r.match(A))throw new RangeError("Format string contains an unescaped latin alphabet character `"+r+"`");return t})).join("")}var X=function(){var a=document.getElementById("vcw-admin-recordings-table");if(null!==a){var o=new DataTable(a,{ajax:ajaxurl+"?action=vcw-get-recordings",columns:[{data:"name"},{data:"created"},{data:"duration"},{data:"size"},{data:"format"},{data:"download"}]}),i=document.getElementById("datepicker-recordings"),u=function(a,o){if(n(2,arguments),!o||"object"!==t(o))return new Date(NaN);var i=o.years?e(o.years):0,u=o.months?e(o.months):0,d=o.weeks?e(o.weeks):0,s=o.days?e(o.days):0,l=o.hours?e(o.hours):0,c=o.minutes?e(o.minutes):0,h=o.seconds?e(o.seconds):0,f=function(t,a){return n(2,arguments),function(t,a){n(2,arguments);var o=r(t),i=e(a);return isNaN(i)?new Date(NaN):i?(o.setDate(o.getDate()+i),o):o}(t,-e(a))}(function(t,a){return n(2,arguments),function(t,a){n(2,arguments);var o=r(t),i=e(a);if(isNaN(i))return new Date(NaN);if(!i)return o;var u=o.getDate(),d=new Date(o.getTime());return d.setMonth(o.getMonth()+i+1,0),u>=d.getDate()?d:(o.setFullYear(d.getFullYear(),d.getMonth(),u),o)}(t,-e(a))}(a,u+12*i),s+7*d),m=1e3*(h+60*(c+60*l));return new Date(f.getTime()-m)}(new Date,{months:1}),d=(new Date).toISOString().substring(0,10);null!==i&&flatpickr(i,{enableTime:!1,mode:"range",dateFormat:"Y-m-d",maxDate:new Date,defaultDate:[d,u],onValueUpdate:function(t,e,n){var r=B(t[0],"MM/dd/yyyy"),a=B(t[1],"MM/dd/yyyy");null!==r&&null!==a&&(function(){var t=document.querySelector(".wrap");if(null!==t){var e=document.createElement("div");e.classList.add("vcw-loading"),t.before(e)}}(),o.clear().draw(),fetch(ajaxurl+"?action=vcw-get-recordings&from="+r+"&to="+a,{method:"GET"}).then((function(t){return t.json()})).then((function(t){var e;null!==(e=document.querySelector(".vcw-loading"))&&e.remove(),o.rows.add(t.data).draw()})))}})}};document.addEventListener("DOMContentLoaded",(function(){X()}))})();