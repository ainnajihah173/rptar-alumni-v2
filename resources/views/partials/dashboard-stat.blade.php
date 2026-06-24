<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-0 shadow-sm h-100 py-2" style="border-radius: 1rem;">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #858796; letter-spacing: 1px;">
                        {{ $title }}
                    </div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $value }}</div>
                </div>
                <div class="col-auto">
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 45px; height: 45px; background-color: {{ $color }}15;">
                        <i class="fas {{ $icon }} fa-lg" style="color: {{ $color }};"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>