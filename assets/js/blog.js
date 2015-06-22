$(document).ready(function() {
    $('.blogpost .like').on('click', function(e) {
        var blogpostId = parseInt($(this).attr('data-blogpost-id'));
        if (!isNaN(blogpostId)) {
            $.post('/blogposts/like', { blogpost_id: blogpostId }, function(data) {
                $('#blogpost-points-' + data.blogpost_id).text(data.likes);
            }, 'json');
        }
        e.preventDefault();
        return false;
    });
});
