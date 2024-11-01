<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Courses</h1>
        <button class="btn btn-primary mb-3" id="addCourseBtn">Add Course</button>
        <table class="table table-bordered" id="coursesTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Course</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="courseForm">
                        <input type="hidden" id="courseId">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (hours)</label>
                            <input type="number" class="form-control" id="duration" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            function loadCourses() {
                $.get("{{ route('courses.all') }}", function(courses) {
                    let rows = '';
                    courses.forEach(course => {
                        rows += `<tr>
                                    <td>${course.name}</td>
                                    <td>${course.description}</td>
                                    <td>${course.duration}</td>
                                    <td>
                                        <button class="btn btn-warning edit" data-id="${course.id}">Edit</button>
                                        <button class="btn btn-danger delete" data-id="${course.id}">Delete</button>
                                    </td>
                                </tr>`;
                    });
                    $('#coursesTable tbody').html(rows);
                });
            }

            loadCourses(); 

            $('#addCourseBtn').click(function() {
                $('#courseForm')[0].reset();
                $('#courseId').val('');
                $('#modalTitle').text('Add Course');
                $('#courseModal').modal('show');
            });

            $(document).on('submit', '#courseForm', function(e) {
                e.preventDefault();
                const id = $('#courseId').val();
                const name = $('#name').val();
                const description = $('#description').val();
                const duration = $('#duration').val();

                if (id) {
                    $.ajax({
                        url: `/courses/${id}`,
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { name, description, duration },
                        success: function() {
                            $('#courseModal').modal('hide');
                            loadCourses(); 
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors;
                            alert(errors.name ? errors.name[0] : '');
                        }
                    });
                } else {
                    $.ajax({
                        url: '{{ route('courses.store') }}',
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { name, description, duration },
                        success: function() {
                            $('#courseModal').modal('hide');
                            loadCourses(); 
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors;
                            alert(errors.name ? errors.name[0] : '');
                        }
                    });
                }
            });

            $(document).on('click', '.edit', function() {
                const id = $(this).data('id');
                $.get(`/courses/${id}`, function(course) {
                    $('#courseId').val(course.id);
                    $('#name').val(course.name);
                    $('#description').val(course.description);
                    $('#duration').val(course.duration);
                    $('#modalTitle').text('Edit Course');
                    $('#courseModal').modal('show');
                });
            });

            $(document).on('click', '.delete', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this course?')) {
                    $.ajax({
                        url: `/courses/${id}`,
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function() {
                            loadCourses(); 
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
