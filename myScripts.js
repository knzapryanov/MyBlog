function deletePostAJAX(postTitle){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var response = xhttp.responseText;
            if(response == 'true'){
                $('#' + postTitle).remove();
                //alert("Post deleted successfuly !");
            }
            else{
                //alert("Post not deleted !");
            }
        }
    };
    xhttp.open("GET", "http://localhost/MyBlog/deletePost.php?title=" + postTitle, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function insertCommentAJAX(userComment, postId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var response = xhttp.responseText;
            var responseObj = JSON.parse(response);

            var div = document.createElement("div");
            div.className = "current-comment-div";
            div.innerHTML = "From: " + responseObj.user + "<br>Comment: " + responseObj.userComment + "<br>Date: " + responseObj.date;
            div.setAttribute("id", "commentIdNum" + responseObj.lastInsertedCommentId);
            
            if(responseObj.user == "admin"){
                var deleteCommentButton = document.createElement("button");
                deleteCommentButton.innerHTML='Delete comment';
                deleteCommentButton.setAttribute("class", "deleteCommentBUtton");
                deleteCommentButton.setAttribute( "onClick", "javascript: deleteCommentAJAX(" + responseObj.lastInsertedCommentId + ");" );
                div.appendChild(deleteCommentButton);
            }

            var newCommentForm = document.getElementById('newCommentForm' + postId);
            newCommentForm.parentNode.insertBefore(div, newCommentForm);
        }
    };
    xhttp.open("POST", "http://localhost/MyBlog/addComment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("userComment="+ userComment +"&postId=" + postId);
}

function deleteCommentAJAX(commentId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var response = xhttp.responseText;
            if(response == 'true'){
                $('#commentIdNum' + commentId).remove();
                //alert("Comment deleted successfuly !");
            }
            else{
                //alert("Comment not deleted !");
            }
        }
    };
    xhttp.open("GET", "http://localhost/MyBlog/deleteComment.php?commentId=" + commentId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}