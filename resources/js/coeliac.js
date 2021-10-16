import Vue from 'vue';
import CoeliacApplication from './App';
import './Components';
import './Plugins';

Vue.config.productionTip = false;

window.coeliac = (config) => new CoeliacApplication(config);

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

function gtag(...args) {
  dataLayer.push(args);
}

gtag('js', new Date());

gtag('config', 'UA-53299243-1');

/// /////
