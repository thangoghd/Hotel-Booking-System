let carousel_s_form =document.getElementById('carousel_s_form');
let carousel_picture_inp =document.getElementById('carousel_picture_input');

carousel_s_form.addEventListener('submit', function(e)
{
    e.preventDefault();
    add_picture();
})

function add_picture()
{
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_picture', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true)
    
    xhr.onload = function()
    {
        var myModal =document.getElementById('carouselSetting');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 'inv_img')
        {
            alert('error', 'Wrong image format!');
            get_carousel();
        }
        else if(this.responseText == 'inv_size'){
            alert('error', 'Image should be less than 2MB!');
        }
        else if(this.responseText == 'upd_failed'){
            alert('error', 'Upload failed! Try Again.');
        }
        else{
            alert('success', 'New image added!');
            carousel_picture_inp.value='';
            get_carousel();
        }
    }

    xhr.send(data);
}

function get_carousel()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        document.getElementById('carousel-data').innerHTML =this.responseText;
        console.log(this.responseText);
    }

    xhr.send('get_carousel')
}

function rem_picture(val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        if(this.responseText == 1)
        {
            alert('success', 'Image removed!');
            get_carousel();
        }
        else alert('error', 'Server down!');
    }

    xhr.send('rem_picture='+val)
}


function showDeleteButton(card) {
    // Hiển thị nút "Delete"
    card.querySelector("#deleteButton").style.display = 'inline-block';
}

function hideDeleteButton(card) {
    // Ẩn nút "Delete"
    card.querySelector("#deleteButton").style.display = 'none';
}

window.onload = function()
{
    get_carousel();
}


  