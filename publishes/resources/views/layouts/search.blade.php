<li class="dropdown">
    <div class="navbar-form">
        <div class="input-group">
            <input id="search-keyword" type="text" class="no-corner form-control" placeholder="留言、产品、新闻..." data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-html="true" data-content="<b>提示：</b><ol><li><code>ctrl</code> + <code>p</code> / <code>command</code> + <code>p</code>可命中本输入框</li><li>输入关键字可以随便搜索，</li><li>输入<code>cp</code>可以直达产品页面，</li><li>输入<code>yh</code>可以直达用户页面....</li><li>查看页 <code>xg</code> / <code>edit</code> 可以快速到达修改页</li><ol>">
            <span class="input-group-addon no-corner"><i class="glyphicon glyphicon-search"></i></span>
        </div>
    </div>
</li>

@section('seaching-js')
<script>window.search_url = '{{route("searching")}}';</script>
<script src="{{ asset('js/searching.js') }}" defer></script>    
@endsection

@push('script')
@yield('seaching-js')
@endpush