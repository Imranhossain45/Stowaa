@extends('layouts.frontend')
@section('title', 'Contact')
@section('content')

  <!-- contact_section - start
              ================================================== -->
  <section class="contact_section section_space">
    <div class="container">
      <div class="row">
        <div class="col col-lg-6">
          <div class="contact_info_wrap">
            <h3 class="contact_title">Address Info</h3>
            <div class="row">
              <div class="col col-md-6">
                <div class="contact_info_list">
                  <ul class="ul_li_block">
                    <li>1416/1,East Jurain,Kadamtoli,Dhaka-1204</li>
                    <li>Email:smimranhossain45@gmail.com</li>
                    <li>Phone:+8801517141272</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col col-lg-6">
          <div class="contact_info_wrap">
            <h3 class="contact_title">Get In Touch</h3>
            <form action="#">
              <div class="form_item">
                <input id="contact-form-name" type="text" name="name" placeholder="Your Name">
              </div>
              <div class="row">
                <div>
                  <div class="form_item">
                    <input id="contact-form-email" type="email" name="email" placeholder="Your Email">
                  </div>
                </div>
                <div>
                  <div class="form_item">
                    <input type="text" name="subject" placeholder="Subject">
                  </div>
                </div>
              </div>
              <div class="form_item">
                <textarea id="contact-form-message" rows="7" name="message" placeholder="Message"></textarea>
              </div>
              <div id="form-msg"></div>
              <button id="contact-form-submit" type="submit" class="btn btn_dark">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact_section - end
              ================================================== -->
@endsection
