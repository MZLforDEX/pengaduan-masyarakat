<script src="<?= base_url() ?>assets/backend/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url() ?>assets/backend/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>assets/backend/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url() ?>assets/backend/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url() ?>assets/backend/js/demo/chart-area-demo.js"></script>
<script src="<?= base_url() ?>assets/backend/js/demo/chart-pie-demo.js"></script>

<script>
  // selected file show
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });
</script>

<script>
<?php if ($this->session->userdata('username')) : ?>
(function() {
  var BASE_URL = '<?= base_url() ?>';
  var shownIds = JSON.parse(sessionStorage.getItem('notifShownIds') || '[]');
  var lastMaxId = parseInt(sessionStorage.getItem('notifLastMaxId') || '0', 10);

  function updateBadge(count) {
    var badge = document.querySelector('.badge-counter');
    if (!badge) {
      var bell = document.querySelector('.navbar-nav .fa-bell');
      if (bell) {
        var li = bell.closest('.nav-item');
        if (li) {
          var existing = li.querySelector('.badge-counter');
          if (existing) existing.remove();
          var b = document.createElement('span');
          b.className = 'badge badge-danger badge-counter';
          li.querySelector('a').appendChild(b);
          badge = b;
        }
      }
    }
    if (badge) {
      if (count > 0) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.style.display = 'inline';
      } else {
        badge.style.display = 'none';
      }
    }
  }

  function showBrowserNotification(notif) {
    if (!('Notification' in window)) return;
    if (Notification.permission === 'granted') {
      var n = new Notification('Pengaduan Masyarakat', {
        body: notif.isi,
        tag: 'notif-' + notif.id_notifikasi,
        requireInteraction: true
      });
      n.onclick = function() {
        window.focus();
        window.location.href = BASE_URL + 'NotifikasiController/read/' + notif.id_notifikasi;
      };
    } else if (Notification.permission === 'default') {
      Notification.requestPermission();
    }
  }

  function poll() {
    fetch(BASE_URL + 'NotifikasiController/unread_json')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        updateBadge(data.unread_count);

        if (data.unread && data.unread.length > 0) {
          var currentMax = 0;
          for (var i = 0; i < data.unread.length; i++) {
            var n = data.unread[i];
            var id = parseInt(n.id_notifikasi, 10);
            if (id > currentMax) currentMax = id;
            if (shownIds.indexOf(id) === -1 && id > lastMaxId) {
              showBrowserNotification(n);
              shownIds.push(id);
            }
          }
          if (currentMax > lastMaxId) {
            lastMaxId = currentMax;
            sessionStorage.setItem('notifLastMaxId', String(lastMaxId));
          }
          sessionStorage.setItem('notifShownIds', JSON.stringify(shownIds));
        }
      })
      .catch(function() {});
  }

  document.addEventListener('DOMContentLoaded', function() {
    if ('Notification' in window && Notification.permission === 'default') {
      Notification.requestPermission();
    }
    poll();
    setInterval(poll, 15000);
  });
})();
<?php endif; ?>
</script>

</body>

</html>
