@extends('frontend.master')
@section('title', 'Event Create-Successful')
@section('custom-styles')
	<style>
		.section-header-style {
		    margin-bottom: 50px;
		    text-transform: capitalize;
		    text-shadow: 0 0 1px #082238;
		    font-size: 28px;
		    /* text-align: center; */
		    font-style: italic;
		    color: #3f5586;
		    /* text-decoration: underline; */
		}
		p {
		    font-size: 16px;
		    line-height: 1.4em;
		}
	</style>
@endsection
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-12">
					  <h3 class="section-header-style">Successful submission of Application for event {{$event_name}} !
					  <br>EVENT REQUEST ID : {{$event_id}}</h3>
					  
					  <div class="row">
						  <div class="col-md-12" style="border-left: 2px solid #3f5586;">
						  	
							
							<p>
							Thanking you for creating the event for CSI.
							</p>
							<p>With warm regards,</p>
							<p>-<br/>
							<strong>(Hony. Secretary)</strong>
							<br/>
							Computer Society of India (CSI)
							<br/>
							<strong>Corporate Office:</strong> 
							<br/>
							Samruddhi Venture Park, Unit No.3, 4th Floor, MIDC 
							<br/>
							Andheri (E), Mumbai-400 093 (Maharashtra), INDIA 
							<br/>
							Phone: +91-22-29261700 Fax : +91-22-28302133
							<br/>
							<strong>
							Education Directorate:</strong>
							<br/>
							National Headquarters, CIT Campus, IV Cross Road
							<br/>
							Taramani, Chennai-600 113 (Tamil Nadu), INDIA                    
							<br/>
							Phone: +91-44-2254 1102 / 03 / 2874
							<br/>
							E-Mail ID: secretary@csi-india.org 
							<br/>
							Visit us at: www.csi-india.org
							</p>
							</div>
						</div>
   				</div>
   			</div>
   		</div>
   		<br/>
   		<br/>
   		<br/>

   	</section>
@endsection