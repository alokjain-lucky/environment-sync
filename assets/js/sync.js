jQuery(document).ready(function ($) {
	// Trigger database sync
	$("#sync-db-live, #sync-db-staging, #sync-db-localhost").on(
		"click",
		function (e) {
			e.preventDefault();
			var environment = $(this).attr("id").split("-")[2];
			$.ajax({
				url: MyEnvironmentSync.ajax_url,
				type: "post",
				data: {
					action: "pull_database",
					nonce: MyEnvironmentSync.nonce,
					environment: environment,
				},
				success: function (response) {
					if (response.success) {
						$("#sync-result").html("<p>" + response.data + "</p>");
					} else {
						$("#sync-result").html("<p>Error: " + response.data + "</p>");
					}
				},
				error: function (xhr, status, error) {
					$("#sync-result").html("<p>AJAX Error: " + error + "</p>");
				},
			});
		}
	);

	// Trigger file sync
	$("#sync-files-live, #sync-files-staging, #sync-files-localhost").on(
		"click",
		function (e) {
			e.preventDefault();
			var environment = $(this).attr("id").split("-")[2];
			$.ajax({
				url: MyEnvironmentSync.ajax_url,
				type: "post",
				data: {
					action: "pull_files",
					nonce: MyEnvironmentSync.nonce,
					environment: environment,
				},
				success: function (response) {
					if (response.success) {
						$("#sync-result").html("<p>" + response.data + "</p>");
					} else {
						$("#sync-result").html("<p>Error: " + response.data + "</p>");
					}
				},
				error: function (xhr, status, error) {
					$("#sync-result").html("<p>AJAX Error: " + error + "</p>");
				},
			});
		}
	);

	// Test FTP credentials
	$("#test-ftp-credentials").on("click", function (e) {
		e.preventDefault();
		var ftp_server = $("#my_environment_sync_ftp_server").val();
		var ftp_user = $("#my_environment_sync_ftp_user").val();
		var ftp_pass = $("#my_environment_sync_ftp_pass").val();
		$.ajax({
			url: MyEnvironmentSync.ajax_url,
			type: "post",
			data: {
				action: "test_ftp_credentials",
				nonce: MyEnvironmentSync.nonce,
				ftp_server: ftp_server,
				ftp_user: ftp_user,
				ftp_pass: ftp_pass,
			},
			success: function (response) {
				if (response.success) {
					alert("FTP credentials are valid.");
				} else {
					alert("FTP credentials are invalid: " + response.data);
				}
			},
			error: function (xhr, status, error) {
				alert("AJAX Error: " + error);
			},
		});
	});

	// Test database credentials
	$("#test-db-credentials").on("click", function (e) {
		e.preventDefault();
		var db_host = $("#my_environment_sync_db_host").val();
		var db_name = $("#my_environment_sync_db_name").val();
		var db_user = $("#my_environment_sync_db_user").val();
		var db_pass = $("#my_environment_sync_db_pass").val();
		$.ajax({
			url: MyEnvironmentSync.ajax_url,
			type: "post",
			data: {
				action: "test_db_credentials",
				nonce: MyEnvironmentSync.nonce,
				db_host: db_host,
				db_name: db_name,
				db_user: db_user,
				db_pass: db_pass,
			},
			success: function (response) {
				if (response.success) {
					alert("Database credentials are valid.");
				} else {
					alert("Database credentials are invalid: " + response.data);
				}
			},
			error: function (xhr, status, error) {
				alert("AJAX Error: " + error);
			},
		});
	});
});
