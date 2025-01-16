(function ($) {
  document.addEventListener('DOMContentLoaded',  function () {
    $('.df_marqueetext_wrapper').each(function (i, ele) {
      if (!ele) return;

      const data = JSON.parse(ele.dataset.settings);

      const config = {
        delayBeforeStart: 1000,
        pauseOnHover: data.ticker_hover,
        duration: parseInt(data.ticker_speed),
        gap: 0,
        direction: 'on' === data.ticker_direction ? "right" : "left",
        duplicated: data.ticker_loop,
        startVisible: 'on' !== data.ticker_direction,
      }

      if (data.ticker_loop) {
        Object.assign(config, {
          gap: parseInt(data.ticker_gap)
        })
      }

      $(ele).marquee(config);
    });
  })
})(jQuery)
