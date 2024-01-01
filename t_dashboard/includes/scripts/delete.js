'use strict';

function delPost(pID, redir) {
    const form = document.createElement('form');
    form.method = "POST";
    form.action = 'includes/postHandler.php?action=delete';
  
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = "postID";
    hiddenField.value = pID;

    const hiddenField2 = document.createElement('input');
    hiddenField2.type = 'hidden';
    hiddenField2.name = "redir";
    hiddenField2.value = redir;

    form.appendChild(hiddenField);
    form.appendChild(hiddenField2);
  
    document.body.appendChild(form);
    form.submit();
}

function delComment(commentID, redir) {
    const form = document.createElement('form');
    form.method = "POST";
    form.action = 'includes/commentHandler.php?action=delete';
  
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = "commentID";
    hiddenField.value = commentID;

    const hiddenField2 = document.createElement('input');
    hiddenField2.type = 'hidden';
    hiddenField2.name = "redir";
    hiddenField2.value = redir;

    form.appendChild(hiddenField);
    form.appendChild(hiddenField2);

  
    document.body.appendChild(form);
    form.submit();
}