<script src="/TuVanTuyenSinh/public/vendor/jquery/jquery.min.js"></script>
  <script src="/TuVanTuyenSinh/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="/TuVanTuyenSinh/public/assets/js/isotope.min.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/owl-carousel.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/lightbox.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/tabs.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/video.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/slick-slider.js"></script>
  <script src="/TuVanTuyenSinh/public/assets/js/custom.js"></script>
  
  <script>
      // Code JS giữ nguyên của template để chạy hiệu ứng cuộn trang
      $('.nav li:first').addClass('active');

      var showSection = function showSection(section, isAnimate) {
        var
        direction = section.replace(/#/, ''),
        reqSection = $('.section').filter('[data-section="' + direction + '"]'),
        reqSectionPos = reqSection.offset().top - 0;

        if (isAnimate) {
          $('body, html').animate({
            scrollTop: reqSectionPos },
          800);
        } else {
          $('body, html').scrollTop(reqSectionPos);
        }
      };

      var checkSection = function checkSection() {
        $('.section').each(function () {
          var
          $this = $(this),
          topEdge = $this.offset().top - 80,
          bottomEdge = topEdge + $this.height(),
          wScroll = $(window).scrollTop();
          if (topEdge < wScroll && bottomEdge > wScroll) {
            var
            currentId = $this.data('section'),
            reqLink = $('a').filter('[href*=\\#' + currentId + ']');
            reqLink.closest('li').addClass('active').
            siblings().removeClass('active');
          }
        });
      };

      $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
        // Chỉ chạy hiệu ứng cuộn nếu link bắt đầu bằng dấu #
        if($(this).attr('href').indexOf('#') !== -1) {
            e.preventDefault();
            showSection($(this).attr('href'), true);
        }
      });

      $(window).scroll(function () {
        checkSection();
      });
  </script>
</body>
</html>