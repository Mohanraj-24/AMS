'use strict';

function likePost(pID, redir) {
    const form = document.createElement('form');
    form.method = "POST";
    form.action = 'includes/postHandler.php?action=like';
  
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