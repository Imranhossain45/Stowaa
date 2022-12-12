@extends('layouts.frontend')
@section('title', 'team')
@section('content')

  <!-- team_section - start
              ================================================== -->
  <section class="team_section section_space">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col col-md-7">
          <div class="team_section_title text-center">
            <h2 class="title_text">Meet Our Team</h2>
            <p class="mb-0">
              Collaboratively administrate empowered markets via plug-and-play maintain networks. Dynamically usable
              procrastinate B2B users after installed base benefits. Dramatically visualize customer directed convergence
              without revolutionary ROI.
            </p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_1.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">Harry Dor</h3>
              <span class="team_member_title">CEO/Founder</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_2.jpg')}}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">John Swim</h3>
              <span class="team_member_title">Fashion Designer</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_3.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">Harry Dor</h3>
              <span class="team_member_title">CEO/Founder</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_4.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">John Swim</h3>
              <span class="team_member_title">Fashion Designer</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_5.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">Harry Dor</h3>
              <span class="team_member_title">CEO/Founder</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_6.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">John Swim</h3>
              <span class="team_member_title">Fashion Designer</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_7.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">Harry Dor</h3>
              <span class="team_member_title">CEO/Founder</span>
            </div>
          </div>
        </div>

        <div class="col col-lg-3 col-md-4 col-sm-6">
          <div class="team_item">
            <div class="team_image">
              <img src="{{ asset('frontend/images/team/team_8.jpg') }}" alt="image_not_found" />
            </div>
            <div class="team_content">
              <h3 class="team_member_name">John Swim</h3>
              <span class="team_member_title">Fashion Designer</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- team_section - end
              ================================================== -->
@endsection
