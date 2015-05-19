<script type="text/javascript">
(function () {

    var domText = document.getElementById('text');
    var editorHelper = document.createElement('p');

    function keydown(e) {
        var keyCode = e.keyCode;
        if (keyCode == 9) {
            var start = domText.selectionStart;
            var end = domText.selectionEnd;
            var length = Math.floor(end - start);
            var min = Math.min(start, end);
            var value = domText.value;
            var regExp = new RegExp('^(.{' + start + '}).{' + length + '}', 'm');
            var index = min + 4;
            value = value.replace(regExp, '$1    ');
            domText.value = value;
            domText.selectionStart = domText.selectionEnd = index;
            return false;
        }
    }

    function add(name, type, handler) {
        var a = document.createElement('a');
        a.href = '#' + name;
        a.textContent = name;
        a.style.marginRight = '5px';
        a.onclick = function (e) {
            var start = domText.selectionStart;
            var end = domText.selectionEnd;
            var length = Math.floor(end - start);
            var min = Math.min(start, end);
            var max = Math.max(start, end);
            var value = domText.value;
            var newValue = value;
            var behind = value.substr(0, min);
            var after = value.substr(max);
            var middle = value.substr(min, length);
            var result = middle;

            if (type == 'inline') {
                result = handler(middle);
            }

            if (type == 'line') {

                var leftIndex = behind.lastIndexOf('\n');
                var middleLeft = '';

                if (leftIndex == -1) {
                    middleLeft = behind;
                    behind = '';
                }
                else {
                    middleLeft = behind.substr(leftIndex + 1);
                    behind = behind.substr(0, leftIndex + 1);
                }

                var rightIndex = after.indexOf('\n');
                var middleRight = '';

                if (middle[length - 1] == '\n') {
                    middle = middle.substr(0, length - 1);
                    after = '\n' + after;
                }
                else if (rightIndex == -1) {
                    middleRight = after;
                    after = '';
                }
                else {
                    middleRight = after.substr(0, rightIndex);
                    after = after.substr(rightIndex);
                }

                middle = middleLeft + middle + middleRight;
                middle = middle.split('\n');

                min = behind.length;
                result = handler(middle);
            }

            newValue = behind + result + after;
            domText.value = newValue;

            if (start > end) {
                domText.selectionStart = min + result.length;
                domText.selectionEnd = min;
            }
            else {
                domText.selectionStart = min;
                domText.selectionEnd = min + result.length;
            }

            return false;
        };
        editorHelper.appendChild(a);
    }

    domText.onkeydown = keydown;
    domText.parentNode.parentNode.insertBefore(editorHelper, domText.parentNode);

    add('code', 'inline', function (code) {return '`' + code + '`';});
    add('strong', 'inline', function (code) {return '__' + code + '__';});
    add('em', 'inline', function (code) {return '_' + code + '_';});
    add('img', 'inline', function (code) {return '![](' + code + ')';});
    add('link', 'inline', function (code) {return '[' + code + '](' + code + ')';});

    add('h3', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = '### ' + list[i];
            }
        })
        return list.join('\n');
    });

    add('h4', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = '#### ' + list[i];
            }
        })
        return list.join('\n');
    });

    add('ul', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = '* ' + list[i];
            }
        })
        return list.join('\n');
    });

    add('ol', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = (i + 1) + '. ' + list[i];
            }
        })
        return list.join('\n');
    });

    add('pre', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = '    ' + list[i];
            }
        })
        return list.join('\n');
    });

    add('blockquote', 'line', function (list) {
        var length = list.length;
        list.forEach(function (item, i) {
            if (list[i] || i < length - 1) {
                list[i] = '> ' + list[i];
            }
        })
        return list.join('\n');
    });
})();
</script>