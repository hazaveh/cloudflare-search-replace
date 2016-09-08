/**
 * Created by mahdi-longhair on 8/18/16.
 */

var original_ip, new_ip;

function showReplaceTool() {
    $('#domains-list').hide();
    $('#replace-tool').fadeIn();
}

function showDomainsList() {
    $('#replace-tool').hide();
    $('#domains-list').fadeIn();
}

function dryRun(){
    original_ip = $('#originalIP').val();
    new_ip = $('#newIP').val();

    if (ValidateIPaddress(original_ip, 'Original IP') && ValidateIPaddress(new_ip, 'New IP')) {
        $('#loading').fadeIn();
        $.ajax({
            type: "POST",
            url: 'controller.php?dry-run=1',
            data: {'originalIP' : original_ip, 'newIP' : new_ip},
            success: function(response){
                $('#loading').fadeOut();
                loadTable(response);
                console.log(response)
            },
            error: function(response){
                $('#loading').fadeOut();
                console.log(response)
            },
            dataType: 'JSON'
        });
    }


}

function ValidateIPaddress(ipaddress, message)
{
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipaddress))
    {
        return (true)
    }
    alert("You have entered an invalid IP address for " + message + ' field')
    return (false)
}

function loadTable(data){
    if (data && data.length > 0) {
        $.each(data, function(k, d){
            var tr = '<tr><td>' + d.type + '</td><td>'+ d.name +'</td><td>'+ d.oldIP +'<td>'+ d.newIP +'</td></td></tr>'
            $('#data-list').append(tr);
        });
        $('#confirmationModal').modal('show');
    } else {
        alert('Could not find any records based on IP address entred.');
    }

}

function doReplace(){
    if (ValidateIPaddress(original_ip, 'Original IP') && ValidateIPaddress(new_ip, 'New IP')) {
        $('#confirmationModal').modal('hide');
        $('#loading').fadeIn();
        $.ajax({
            type: "POST",
            url: 'controller.php?live-run=1',
            data: {'originalIP' : original_ip, 'newIP' : new_ip},
            success: function(response){
                if(response.result == 'success') {
                    $('#loading').fadeOut();
                    alert('Process is running in the background. Please do not shutdown the machine running this script. it may take few minutes for the process to complete');
                }
                console.log(response)
            },
            error: function(response){
                $('#loading').fadeOut();
                console.log(response)
            },
            dataType: 'JSON'
        });
    }
}