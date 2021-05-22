import Vue from 'vue';
import CoeliacApplication from "./App";
import './Components';
import './Plugins';

Vue.config.productionTip = false;

window.coeliac = function (config) {
    return new CoeliacApplication(config);
}

coeliac().build();

document.querySelectorAll('.lazy').forEach((image) => {
    image.setAttribute('src', `data:image/svg+xml,%3Csvg
        xmlns='http://www.w3.org/2000/svg'
        viewBox='0 0 3 2'%3E%3C/svg%3E"`);

    image.width = '100%';
    image.height = 'auto';
    image.style.paddingBottom = '52.5%';
});

document.querySelectorAll('.page-box iframe').forEach((iframe) => {
    setTimeout(() => {
        Array.from(iframe.attributes).forEach((attribute) => {
            if (attribute.name === 'src') {
                return;
            }

            iframe.removeAttribute(attribute.name);
        });

        const wrapper = document.createElement('div');
        wrapper.classList.add('iframe-wrapper');
        iframe.parentElement.insertBefore(wrapper, iframe);
        wrapper.appendChild(iframe);
    }, 500);
});

window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}

gtag('js', new Date());

gtag('config', 'UA-53299243-1');

////////
setTimeout(() => {
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '376206517120953');
    fbq('track', 'PageView');
}, 5000);

!function (A, n, e) {
    function o(A) {
        var n = c.className, e = Modernizr._config.classPrefix || "";
        if (u && (n = n.baseVal), Modernizr._config.enableJSClass) {
            var o = new RegExp("(^|\\s)" + e + "no-js(\\s|$)");
            n = n.replace(o, "$1" + e + "js$2")
        }
        Modernizr._config.enableClasses && (n += " " + e + A.join(" " + e), u ? c.className.baseVal = n : c.className = n)
    }

    function a(A, n) {
        return typeof A === n
    }

    function t() {
        var A, n, e, o, t, i, l;
        for (var f in r) if (r.hasOwnProperty(f)) {
            if (A = [], n = r[f], n.name && (A.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length)) for (e = 0; e < n.options.aliases.length; e++) A.push(n.options.aliases[e].toLowerCase());
            for (o = a(n.fn, "function") ? n.fn() : n.fn, t = 0; t < A.length; t++) i = A[t], l = i.split("."), 1 === l.length ? Modernizr[l[0]] = o : (!Modernizr[l[0]] || Modernizr[l[0]] instanceof Boolean || (Modernizr[l[0]] = new Boolean(Modernizr[l[0]])), Modernizr[l[0]][l[1]] = o), s.push((o ? "" : "no-") + l.join("-"))
        }
    }

    function i(A, n) {
        if ("object" == typeof A) for (var e in A) f(A, e) && i(e, A[e]); else {
            A = A.toLowerCase();
            var a = A.split("."), t = Modernizr[a[0]];
            if (2 == a.length && (t = t[a[1]]), "undefined" != typeof t) return Modernizr;
            n = "function" == typeof n ? n() : n, 1 == a.length ? Modernizr[a[0]] = n : (!Modernizr[a[0]] || Modernizr[a[0]] instanceof Boolean || (Modernizr[a[0]] = new Boolean(Modernizr[a[0]])), Modernizr[a[0]][a[1]] = n), o([(n && 0 != n ? "" : "no-") + a.join("-")]), Modernizr._trigger(A, n)
        }
        return Modernizr
    }

    var s = [], r = [], l = {
        _version: "3.6.0",
        _config: {classPrefix: "", enableClasses: !0, enableJSClass: !0, usePrefixes: !0},
        _q: [],
        on: function (A, n) {
            var e = this;
            setTimeout(function () {
                n(e[A])
            }, 0)
        },
        addTest: function (A, n, e) {
            r.push({name: A, fn: n, options: e})
        },
        addAsyncTest: function (A) {
            r.push({name: null, fn: A})
        }
    }, Modernizr = function () {
    };
    Modernizr.prototype = l, Modernizr = new Modernizr;
    var f, c = n.documentElement, u = "svg" === c.nodeName.toLowerCase();
    !function () {
        var A = {}.hasOwnProperty;
        f = a(A, "undefined") || a(A.call, "undefined") ? function (A, n) {
            return n in A && a(A.constructor.prototype[n], "undefined")
        } : function (n, e) {
            return A.call(n, e)
        }
    }(), l._l = {}, l.on = function (A, n) {
        this._l[A] || (this._l[A] = []), this._l[A].push(n), Modernizr.hasOwnProperty(A) && setTimeout(function () {
            Modernizr._trigger(A, Modernizr[A])
        }, 0)
    }, l._trigger = function (A, n) {
        if (this._l[A]) {
            var e = this._l[A];
            setTimeout(function () {
                var A, o;
                for (A = 0; A < e.length; A++) (o = e[A])(n)
            }, 0), delete this._l[A]
        }
    }, Modernizr._q.push(function () {
        l.addTest = i
    }), Modernizr.addAsyncTest(function () {
        function A(A, n, e) {
            function o(n) {
                var o = n && "load" === n.type ? 1 == a.width : !1, t = "webp" === A;
                i(A, t && o ? new Boolean(o) : o), e && e(n)
            }

            var a = new Image;
            a.onerror = o, a.onload = o, a.src = n
        }

        var n = [{
                uri: "data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=",
                name: "webp"
            }, {
                uri: "data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA==",
                name: "webp.alpha"
            }, {
                uri: "data:image/webp;base64,UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA",
                name: "webp.animation"
            }, {uri: "data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=", name: "webp.lossless"}],
            e = n.shift();
        A(e.name, e.uri, function (e) {
            if (e && "load" === e.type) for (var o = 0; o < n.length; o++) A(n[o].name, n[o].uri)
        })
    }), Modernizr.addAsyncTest(function () {
        var A = new Image;
        A.onload = A.onerror = function () {
            i("jpeg2000", 1 == A.width)
        }, A.src = "data:image/jp2;base64,/0//UQAyAAAAAAABAAAAAgAAAAAAAAAAAAAABAAAAAQAAAAAAAAAAAAEBwEBBwEBBwEBBwEB/1IADAAAAAEAAAQEAAH/XAAEQED/ZAAlAAFDcmVhdGVkIGJ5IE9wZW5KUEVHIHZlcnNpb24gMi4wLjD/kAAKAAAAAABYAAH/UwAJAQAABAQAAf9dAAUBQED/UwAJAgAABAQAAf9dAAUCQED/UwAJAwAABAQAAf9dAAUDQED/k8+kEAGvz6QQAa/PpBABr994EAk//9k="
    }), Modernizr.addAsyncTest(function () {
        var A = new Image;
        A.onload = A.onerror = function () {
            i("jpegxr", 1 == A.width, {aliases: ["jpeg-xr"]})
        }, A.src = "data:image/vnd.ms-photo;base64,SUm8AQgAAAAFAAG8AQAQAAAASgAAAIC8BAABAAAAAQAAAIG8BAABAAAAAQAAAMC8BAABAAAAWgAAAMG8BAABAAAAHwAAAAAAAAAkw91vA07+S7GFPXd2jckNV01QSE9UTwAZAYBxAAAAABP/gAAEb/8AAQAAAQAAAA=="
    }), t(), o(s), delete l.addTest, delete l.addAsyncTest;
    for (var d = 0; d < Modernizr._q.length; d++) Modernizr._q[d]();
    A.Modernizr = Modernizr
}(window, document);
