<div class="card">
  <div class="card-image">
    <figure class="image is-2by1">
      <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img src="{{ Auth::user()->profileImage('normal') }}" alt="Profile Image">
        </figure>
      </div>
      <div class="media-content">
        <p class="subtitle m-0">
          {{ optional(Auth::user())->profile->display_name }}
        </p>
        <small>{{ '@' . Auth::user()->username }}</small>

      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Phasellus nec iaculis mauris.
    </div>
  </div>
</div>