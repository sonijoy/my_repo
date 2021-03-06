jQuery(document).ready(function () {
    jQuery(".fine-uploader").fineUploaderS3({
        debug: true,
        request: {
            endpoint: s3_uploader_bucket + '.s3.amazonaws.com',
            accessKey: s3_uploader_access_key
        },
        objectProperties: {
    acl: "public-read"
        },
        cors: {
    //all requests are expected to be cross-domain requests
    expected: true,

    //if you want cookies to be sent along with the request
    sendCredentials: true
  },
        signature: {
            endpoint: '/s3_uploader_cors',
        },
        uploadSuccess: {
            endpoint: ajaxurl,	// ajaxurl defined by wordpress
            params: {
              action : "s3_uploader_success",
              post_id : jQuery("#post_ID").val(),
              acf_name : jQuery("#acf_name").val()
            }
        },
        /* iframeSupport: {
            localBlankPagePath: '/cltv_archive_upload_success'
        }, */
        retry: {
           enableAuto: true // defaults to false
        }
    });
  jQuery("#fine-uploader").on("complete", function ( id, name, response, xhr ){
	  jQuery("#file-name").html("Video: " + response);
  });
});
