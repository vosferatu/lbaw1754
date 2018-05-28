<div class="col-sm-2">
                <nav id="sidebar">
                    <div class="list-group">

                            @foreach ($tags as $tag)
                            <a href="/tag/{{ $tag->name  }}" class="list-group-item list-group-item-action ">{{ $tag->name }}</a>
                        @endforeach
                       
                    </div>

                    <footer>
                        <p><a href={{ route('about') }}>About</a> &middot; <a
                                href={{ route('faq') }}>FAQ</a></p>
                        <p> <a href={{ route('contentpolicy') }}>Content Policy</a> &middot; <a
                                href={{ route('contact') }}>Contact</a></p>
                    </footer>
                  </nav>
              </div>
