$(document).ready(function() {
    $('#create-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'create_news.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('#messages').html('<div class="success-message">Nachricht erfolgreich erstellt!</div>');
                    $('#create-form')[0].reset();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $('#messages').html('<div class="error-message">' + data.error + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX-Fehler:', xhr.responseText);
                $('#messages').html('<div class="error-message">AJAX-Fehler: ' + error + '</div>');
            }
        });
    });

    $('.edit-button').on('click', function() {
        var newsId = $(this).data('id');

        $.ajax({
            url: 'get_news.php',  
            method: 'GET',
            data: { id: newsId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('#edit-id').val(data.news.id);
                    $('#edit-title').val(data.news.title);
                    $('#edit-content').val(data.news.content);
                    $('#edit-news').removeClass('hidden');
                    $('#create-news').addClass('hidden');
                } else {
                    $('#messages').html('<div class="error-message">' + data.error + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX-Fehler:', xhr.responseText);
                $('#messages').html('<div class="error-message">AJAX-Fehler: ' + error + '</div>');
            }
        });
    });

    $('#edit-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'update_news.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    window.location.href = 'admin.php'; 
                } else {
                    $('#messages').html('<div class="error-message">' + data.error + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX-Fehler:', xhr.responseText);
                $('#messages').html('<div class="error-message">AJAX-Fehler: ' + error + '</div>');
            }
        });
    });

    $('.delete-button').on('click', function() {
        var newsId = $(this).data('id');
        
        $.ajax({
            url: 'delete_news.php',
            method: 'POST',
            data: { id: newsId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('#messages').html('<div class="success-message">Nachricht erfolgreich gelöscht!</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $('#messages').html('<div class="error-message">' + data.error + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX-Fehler:', xhr.responseText);
                $('#messages').html('<div class="error-message">AJAX-Fehler: ' + error + '</div>');
            }
        });
    });

    $('#logout-button').on('click', function() {
        window.location.href = 'logout.php';
    });
});
