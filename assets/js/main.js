(function () {
  function ajustarMiniaturas() {
    document.querySelectorAll('.preview-caixa').forEach(function (caixa) {
      var iframe = caixa.querySelector('iframe');
      if (!iframe) return;
      iframe.style.transform = 'scale(' + (caixa.clientWidth / 1280) + ')';
    });
  }

  document.addEventListener('DOMContentLoaded', ajustarMiniaturas);
  window.addEventListener('load', ajustarMiniaturas);
  window.addEventListener('resize', ajustarMiniaturas);
})();