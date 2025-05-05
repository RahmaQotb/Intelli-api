@if (session()->has("success"))
    <div class="alert alert-success">
        {{session()->get("success")}}
    </div>
@endif
@if (session()->has("fails"))
    <div class="alert alert-danger">
        {{session()->get("fails")}}
    </div>
@endif
