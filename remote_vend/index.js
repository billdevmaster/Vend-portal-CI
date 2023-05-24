$(document).ready(function() {
  console.log("ready!");
  $("#submit").click(function() {
    var form = new FormData();
    form.append("machine_id", $("#machineId").val());
    form.append("aisle_number", "10");
    form.append("customer_name", $("#name").val());
    form.append("vend_id", $("#vendid").val());

    var settings = {
      url: "http://tcn.vendportal.com/index.php/api/Remote_Vend_API_Controller",
      headers: {
        Authorization:
          "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6IjExMTI0NSIsInRpbWUiOjE2MTkzNTI1OTYsImNsaWVudF9pZCI6Ijg0In0.V1ZaDeB0lF2jH0HVoH1MCbial7Uwx-CsgMBJeVLfpu0"
      },
      method: "POST",
      timeout: 0,
      processData: false,
      mimeType: "multipart/form-data",
      contentType: false,
      data: form
    };

    $.ajax(settings).done(function(response) {
      console.log(response);
    });
  });
});
