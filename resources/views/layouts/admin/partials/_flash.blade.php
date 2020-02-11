@if (session('notice'))
    <div class="am-g">
        <div class="am-u-md-12">
            <div class="am-alert am-alert-success" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                {{ session('notice') }}
            </div>
        </div>
    </div>
@endif

@if (session('alert'))
    <div class="am-g">
        <div class="am-u-md-12">
            <div class="am-alert am-alert-danger" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                {{ session('alert') }}
            </div>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="am-g">
        <div class="am-u-md-12">
            <div class="am-alert am-alert-danger" data-am-alert>
                <button type="button" class="am-close">&times;</button>
                <h2>发生了以下错误!</h2>
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endif