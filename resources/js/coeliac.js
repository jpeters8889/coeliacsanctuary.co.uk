import Vue from 'vue';
import CoeliacApplication from "./CoeliacApplication";
import './Plugins';

Vue.config.productionTip = false;

import './components-dynamic';

window.coeliac = function (config) {
    return new CoeliacApplication(config);
}

coeliac().build();

document.querySelectorAll('.lazy').forEach((image) => {
    image.setAttribute('src', `data:image/svg+xml,%3Csvg
        xmlns='http://www.w3.org/2000/svg'
        viewBox='0 0 3 2'%3E%3C/svg%3E"`);

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

//////////
setTimeout(() => {
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) {
            return;
        }

        n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };

        if (!f._fbq) {
            f._fbq = n;
        }

        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.defer = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1163828547057901');
    fbq('track', 'PageView');
}, 5000);
