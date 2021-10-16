// eslint-disable-next-line import/prefer-default-export
export const init = () => {
  window.dataLayer = window.dataLayer || [];

  function gtag(...args) {
    dataLayer.push(args);
  }

  window.gtag = gtag;

  gtag('config', 'GA_MEASUREMENT_ID', { transport_type: 'beacon' });
  gtag('js', new Date());

  gtag('config', 'UA-53299243-1');
};
