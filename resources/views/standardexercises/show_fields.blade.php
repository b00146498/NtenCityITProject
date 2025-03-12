<table class="table table-bordered table-sm">
    <tbody>
        <tr>
            <th style="width: 30%;">Exercise Name</th>
            <td>{!! $standardexercises->exercise_name !!}</td>
        </tr>
        <tr>
            <th style="width: 30%;">Exercise Video</th>
            <td>
                @if (!empty($standardexercises->exercise_video_link))
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" 
                            src="{{ $standardexercises->exercise_video_link }}" 
                            width="250" height="140"
                            frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <span>No video available</span>
                @endif
            </td>
        </tr>
        <tr>
            <th style="width: 30%;">Target Body Area</th>
            <td>{!! $standardexercises->target_body_area !!}</td>
        </tr>
    </tbody>
</table>
