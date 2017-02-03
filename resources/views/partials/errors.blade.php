@if (count($errors) > 0)
    <div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>糟糕!</strong>
        您的输入有一些问题：<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif