<style>
    .project-box {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #eee;
        transition: 0.2s;
    }

    .project-box:hover {
        background: #f1f3f5;
    }

    .project-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .project-value {
        font-size: 15px;
        font-weight: 600;
        color: #212529;
    }

    .project-description {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #eee;
    }
</style>


<div class="row">

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Project Title</div>
            <div class="project-value">{{ $project->project_title }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Company</div>
            <div class="project-value">{{ $project->company_name }}</div>
        </div>
    </div>

    @php
        $department = DB::table('departments')->where('id', $project->project_department)->first();
    @endphp

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Domain</div>
            <div class="project-value">{{ $department->department_name ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Technology</div>
            <div class="project-value">{{ $project->technology }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Start Date</div>
            <div class="project-value">
                {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">End Date</div>
            <div class="project-value">
                {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="project-box">
            <div class="project-label">Employee Required</div>
            <div class="project-value">{{ $project->noe }}</div>
        </div>
    </div>

    <div class="col-md-12 mt-3">

        <div class="project-label mb-1">Description</div>

        <div class="project-description">
            {{ $project->description }}
        </div>

    </div>

    @if ($project->project_document)
        <div class="col-md-12 mt-3 text-end">

            <a href="{{ asset('project_documents/' . $project->project_document) }}" target="_blank"
                class="btn btn-success btn-sm">

                <i class="bi bi-download me-1"></i> Download Document

            </a>

        </div>
    @endif

</div>
