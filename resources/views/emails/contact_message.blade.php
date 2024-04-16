<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    

    <style type="text/css">
    	.section-title::before {
			    position: absolute;
			    content: "";
			    width: 45px;
			    height: 2px;
			    top: 50%;
			    left: -55px;
			    margin-top: -1px;
			    background: var(--primary);
			}

			.section-title::after {
			    position: absolute;
			    content: "";
			    width: 45px;
			    height: 2px;
			    top: 50%;
			    right: -55px;
			    margin-top: -1px;
			    background: var(--primary);
			}

			.section-title.text-start::before,
			.section-title.text-end::after {
			    display: none;
			}

			.service-item {
    height: 320px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    background: #FFFFFF;
    box-shadow: 0 0 45px rgba(0, 0, 0, .08);
    transition: .5s;
}

 .newsletter {
	    position: relative;
	    z-index: 1;
	}

	.footer {
	    position: relative;
	    margin-top: -110px;
	    padding-top: 180px;
	}

	.footer .btn.btn-social {
	    margin-right: 5px;
	    width: 35px;
	    height: 35px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    color: var(--light);
	    border: 1px solid #FFFFFF;
	    border-radius: 35px;
	    transition: .3s;
	}

    </style>

    
</head>

<body>
    <div class="section-title">
        <h3>{{ $data['subject'] }}</h3>
    </div>

    <div class="service-item ">
    	<h3>De: {{ $data['email'] }}</h3>
    	<p>
    		{{ $data['message']}}
    	</p>
    </div>

    <div class="footer newsletter">
    	<p>
    		{{ $data['name']}}
    	</p>
    </div>

</body>

</html>