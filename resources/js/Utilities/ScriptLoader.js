// eslint-disable-next-line import/prefer-default-export
export function loadScript(script) {
  return new Promise((resolve) => {
    if (document.querySelector(`script[src="${script}"]`)) {
      resolve();

      return;
    }

    const scriptElement = document.createElement('script');

    scriptElement.setAttribute('src', script);

    document.body.appendChild(scriptElement);

    scriptElement.addEventListener('load', resolve);
  });
}
