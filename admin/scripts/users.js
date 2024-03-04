

function add_room()
{
    let data = new FormData();
    data.append('add_room', '');
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('decription', add_room_form.elements['decription'].value);

    let features = []

    add_room_form.elements['features'].forEach(element => {
        if(element.checked){
            features.push(element.value);
        }
    });

    let facilities = []

    add_room_form.elements['facilities'].forEach(element => {
        if(element.checked){
            facilities.push(element.value);
        }
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    
    xhr.onload = function()
    {
        var myModal =document.getElementById('addRoom');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1)
        {
            alert('success', 'New room added!');
            add_room_form.reset();
            get_all_rooms();
        }
        else{
            alert('error', 'Unknow error!');

        }
    }

    xhr.send(data);
}

function get_users()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        document.getElementById('users-data').innerHTML = this.responseText;
    }

    xhr.send('get_users');
}

function toggle_status(id, val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        if(this.responseText == 1){ 
            
            alert('success', 'Status toggle!');
            get_users();
        }
        else alert('error', 'Unkown error!');
    }

    xhr.send('toggle_status='+id+'&value='+val);
}



function delete_user(user_id)
{
    if(confirm("Are you sure to remove this user?")){
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('delete_user', '');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true)
        
        xhr.onload = function()
        {
            if(this.responseText == 1)
            {
                alert('success', 'The user has been removed!');
                get_users();
            }
            else{
                alert('error', 'Unknow error!');
            }
        }
        xhr.send(data);
    }
}

function search_user(username)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        document.getElementById('users-data').innerHTML = this.responseText;
    }

    xhr.send('search_user&name='+username);
}

window.onload = function()
{
    get_users();
}