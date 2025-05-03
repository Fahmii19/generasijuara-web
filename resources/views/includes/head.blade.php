<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Dashboard - Generasi Juara</title>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
<link href="{{asset('assets/admin/dist/css/styles.css')}}" rel="stylesheet" />
<link rel="icon" type="image/x-icon" href="{{asset('assets/images/logo_web.png')}}" />
<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
<link href="{{asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
<style type="text/css">
	.table-bordered{border:1px solid #e3e6f0}.table-bordered td,.table-bordered th{border:1px solid #e3e6f0}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{color:#858796;background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#cdd8f6}.table-primary tbody+tbody,.table-primary td,.table-primary th,.table-primary thead th{border-color:#a3b6ee}.table-hover .table-primary:hover{background-color:#b7c7f2}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#b7c7f2}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#dddde2}.table-secondary tbody+tbody,.table-secondary td,.table-secondary th,.table-secondary thead th{border-color:#c0c1c8}.table-hover .table-secondary:hover{background-color:#cfcfd6}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#cfcfd6}.table-success,.table-success>td,.table-success>th{background-color:#bff0de}.table-success tbody+tbody,.table-success td,.table-success th,.table-success thead th{border-color:#89e2c2}.table-hover .table-success:hover{background-color:#aaebd3}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#aaebd3}.table-info,.table-info>td,.table-info>th{background-color:#c7ebf1}.table-info tbody+tbody,.table-info td,.table-info th,.table-info thead th{border-color:#96dbe4}.table-hover .table-info:hover{background-color:#b3e4ec}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#b3e4ec}.table-warning,.table-warning>td,.table-warning>th{background-color:#fceec9}.table-warning tbody+tbody,.table-warning td,.table-warning th,.table-warning thead th{border-color:#fadf9b}.table-hover .table-warning:hover{background-color:#fbe6b1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#fbe6b1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f8ccc8}.table-danger tbody+tbody,.table-danger td,.table-danger th,.table-danger thead th{border-color:#f3a199}.table-hover .table-danger:hover{background-color:#f5b7b1}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f5b7b1}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-light tbody+tbody,.table-light td,.table-light th,.table-light thead th{border-color:#fbfcfd}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#d1d1d5}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#a9aab1}.table-hover .table-dark:hover{background-color:#c4c4c9}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#c4c4c9}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#5a5c69;border-color:#6c6e7e}.table .thead-light th{color:#6e707e;background-color:#eaecf4;border-color:#e3e6f0}.table-dark{color:#fff;background-color:#5a5c69}.table-dark td,.table-dark th,.table-dark thead th{border-color:#6c6e7e}.table-dark
	.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{color:#fff;background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}.table-responsive>.table-bordered{border:0}.table-bordered td,.table-bordered th{border:1px solid #dddfeb!important}
	
	label.is-invalid {
	    color: red;
	    font-size: 0.7rem;
	    display: block;
	    margin-top: 5px;
	}

	.was-validated .form-control:valid, 
	.was-validated .dataTable-input:valid, 
	.form-control.valid, 
	.form-control.is-valid, 
	.valid.dataTable-input,
	.is-valid.dataTable-input {
	  border-color: #00ac69;
	  padding-right: calc(1em + 1.75rem);
	  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2300ac69' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
	  background-repeat: no-repeat;
	  background-position: right calc(0.25em + 0.4375rem) center;
	  background-size: calc(0.5em + 0.875rem) calc(0.5em + 0.875rem);
	}

</style>
