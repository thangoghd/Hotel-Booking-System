
let feature_s_form =document.getElementById('feature_s_form');
let facility_s_form =document.getElementById('facility_s_form');
feature_s_form.addEventListener('submit', function(e)
{
    e.preventDefault();
    add_feature();
})

function add_feature()
{
    let data = new FormData();
    data.append('name', feature_s_form.elements['feature_name'].value);
    data.append('add_feature', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    
    xhr.onload = function()
    {
        var myModal =document.getElementById('featuresSetting');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1)
        {
            alert('success', 'New feature added!');
            feature_s_form.elements['feature_name'].value='';
            get_features();
        }
        else{
            alert('error', 'Unknow error!');

        }
    }

    xhr.send(data);
}

function get_features()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        document.getElementById('features-data').innerHTML =this.responseText;
        console.log(this.responseText);
    }

    xhr.send('get_features')
}

function rem_feature(val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        if(this.responseText == 1)
        {
            alert('success', 'The feature has been removed!');
            get_features();
        }
        else if(this.responseText == 'room_added') alert('error', 'Feature id added in room!');
        else alert('error', 'Unknow error!');
    }

    xhr.send('rem_feature='+val)
}

facility_s_form.addEventListener('submit', function(e)
{
    e.preventDefault();
    add_facility();
})

function add_facility()
{
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('decription', facility_s_form.elements['facility_decription'].value);
    data.append('add_facility', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    
    xhr.onload = function()
    {
        var myModal =document.getElementById('facilitiesSetting');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 'inv_img')
        {
            alert('error', 'Only SVG images are allowed!');
            get_general();
        }
        else if(this.responseText == 'inv_size'){
            alert('error', 'Image should be less than 2MB!');
        }
        else if(this.responseText == 'upd_failed'){
            alert('error', 'Upload failed! Try Again.');
        }
        else{
            alert('success', 'New facility added!');
            facility_s_form.reset();
            get_facilities();
        }
    }

    xhr.send(data);
}

function get_facilities()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        document.getElementById('facilities-data').innerHTML =this.responseText;
        console.log(this.responseText);
    }

    xhr.send('get_facilities')
}

function rem_facilities(val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true)
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function()
    {
        if(this.responseText == 1)
        {
            alert('success', 'The facility has been removed!');
            get_facilities();
        }
        else if(this.responseText == 'room_added') alert('error', 'Facility id added in room!');
        else alert('error', 'Unknow error!');
    }

    xhr.send('rem_facilities='+val)
}
window.onload = function()
{
    get_features();
    get_facilities();
}
