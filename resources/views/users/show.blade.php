
@extends('users.master')

@section('profile')
        <div class="profile-extended">
            <div class="container-fluid">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-comment-tab" data-toggle="pill" href="#pills-comment" role="tab" aria-controls="pills-comment" aria-selected="false">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-subscribe-tab" data-toggle="pill" href="#pills-subscribe" role="tab" aria-controls="pills-subscribe" aria-selected="false">Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-savedpost-tab" data-toggle="pill" href="#pills-savedpost" role="tab" aria-controls="pills-savedpost" aria-selected="false">Saved Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-savedcomment-tab" data-toggle="pill" href="#pills-savedcomment" role="tab" aria-controls="pills-savedcomment" aria-selected="false">Saved Comments</a>
                    </li>

                    @if ($user->id == Auth::id())
                    <li class="nav-item ml-auto">
                        <a href={{ url('user/edit') }} class="btn btn-outline-primary ml-auto" id="pills-settings-tab"> <i class="fas fa-cog"></i> Settings</a>
                    </li>
                    @endif
                    

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        @foreach($user->posts as $post)
                        <div class="row col-10"> 
                            @include('layouts.partial-post')
                        </div>
                        @endforeach
                    </div>
    
    
                    <div class="tab-pane fade" id="pills-comment" role="tabpanel" aria-labelledby="pills-comment-tab">
                        @foreach($user->comments as $comment)
                        <div class="row col-10">
                             @include('layouts.comment')
                        </div>
                        @endforeach

                    </div>

                
                    <div class="tab-pane fade" id="pills-subscribe" role="tabpanel" aria-labelledby="pills-subscribe-tab">
                       {{--@foreach($user->tags as $tag)
                        <div class="row col-10">
                             @include('layouts.partial-post')
                        </div>
                        @endforeach --}}

                    </div>
                                    
                    <div class="tab-pane fade" id="pills-savedpost" role="tabpanel" aria-labelledby="pills-savedpost-tab">
                        @foreach($user->saves as $save)
                            @foreach($save->content->posts as $post)
                        <div class="row col-10">
                             @include('layouts.partial-post')
                        </div>
                        @endforeach
                        @endforeach


                    </div>

                                    
                    <div class="tab-pane fade" id="pills-savedcomment" role="tabpanel" aria-labelledby="pills-savedcomment-tab" >
                            @foreach($user->saves as $save)
                            @foreach($save->content->comments as $comment)
                        <div class="row col-10">
                             @include('layouts.comment')
                        </div>
                        @endforeach
                        @endforeach

                    </div>

                        
                </div>
            </div>
        </div>
    
    
        <!-- Settings Modal -->
        <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Settings</h5>
                        <button id="editsettings-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form lpformnum="1">
                            <fieldset>
    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Cátia Sofia Oliveira Ribeiro " style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country</label>
                                    <input type="text" class="form-control" id="country" aria-describedby="emailHelp" placeholder="Brasil" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
    
                                <div class="form-group">
                                    <label for="comment">Bio:</label>
                                    <textarea class="form-control" rows="5" id="comment" placeholder="Cátia Sofia Ribeiro, mais conhecida por Sofia Ribeiro (2 de Outubro de 1984) é uma atriz e modelo portuguesa."></textarea>
                                </div>
    
                                <div class="form-group">
                                    <label for="exampleInputFile">Picture upload</label>
                                    <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                                </div>
    
                                <button type="submit" class="btn btn-primary">Save changes</button>
    
                                <div style="margin: 1.5rem 0; border-bottom: solid; border-width: 0.06rem;" > </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" class="form-control-plaintext" id="staticEmail" value="email@example.com">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="exampleInputEmail1">New Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                    <small id="emailHelp" class="form-text text-muted">A confirmation email will be sent to your current email address.</small>
                                </div>
    
                                <button type="submit" class="btn btn-primary">Save changes</button>
    
                                <div style="margin: 1.5rem 0; border-bottom: solid; border-width: 0.06rem;" > </div>
    
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly="" class="form-control-plaintext" id="staticEmail" value="123*********">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="exampleInputPassword1">New Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
    
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Comfirm Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                    <small id="emailHelp" class="form-text text-muted">A confirmation email will be sent to your email address.</small>
                                </div>
    
                                <button type="submit" class="btn btn-primary">Save changes</button>
    
    
                                <div style="margin: 1.5rem 0; border-bottom: solid; border-width: 0.06rem;" ><p></p></div>
    
                                <p class="text-danger">If you delete your account all your information will be lost.</p>
                                <button type="button" class="btn btn-danger">Delete Account</button>
                            </fieldset>
                        </form>
                    </div>
    
    
    
    
    
@endsection
