$(function () {
    const $leaveComment = $('#leave-comment');
    const $cancelComment = $('#cancel-comment');
    const $createCommentForm = $('#create-comment-form');
    const $commentsWrapper = $('#comments-wrapper');
    const $commentCount = $('#comment-count');
    let $editComment = $('.comment-actions .item-edit-action');
    let $deleteComment = $('.comment-actions .item-delete-action');

    $leaveComment.click(() => {
        $leaveComment
            .attr('rows', 2)
            .closest('.create-comment')
            .addClass('focused');
    })

    $cancelComment.click(() => {
        resetForm();
    })

    $createCommentForm.submit((e) => {
        e.preventDefault();

        $.ajax({
            method: $createCommentForm.attr('method'),
            url: $createCommentForm.attr('action'),
            data: $createCommentForm.serializeArray(),
            success: (res) => {
                if (res.success) {
                    $commentsWrapper.prepend(res.comment);
                    resetForm();
                    $commentCount.text(+$commentCount.text() + 1);
                    initComments();
                }
            }
        })
    })

    initComments();

    function resetForm() {
        $leaveComment.val('').attr('rows', 1).closest('.create-comment').removeClass('focused');
    }

    function initComments() {
        let $deleteComment = $('.comment-actions .item-delete-action');
        $deleteComment.off('click').on('click', onDeleteClick);

    }

    function onDeleteClick(e) {
        e.preventDefault();
        const $delete = $(e.target);

        if (confirm('Are you sure you want to delete that comment ?')) {
            $.ajax({
                method: 'post',
                url: $delete.attr('href'),
                success: (res) => {
                    if (res.success) {
                        $delete.closest('.comment-item').remove();
                        $commentCount.text(+$commentCount.text() - 1);
                    }
                }
            })
        }
    }
})