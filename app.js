var __spreadArray = (this && this.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};
// Sample data
var adminData = {
    teachers: [],
    students: []
};
function renderPortal(role) {
    var portal = document.getElementById('portal');
    portal.innerHTML = '';
    switch (role) {
        case 'admin':
            renderAdminPortal(portal);
            break;
        case 'teacher':
            renderTeacherPortal(portal);
            break;
        case 'student':
            renderStudentPortal(portal);
            break;
    }
    portal.style.display = 'block';
}
function renderAdminPortal(portal) {
    portal.innerHTML = "<h2>Admin Portal</h2>\n        <h3>Allot Teacher Subjects</h3>\n        <input type=\"text\" id=\"teacher-name\" placeholder=\"Teacher Name\">\n        <input type=\"text\" id=\"subject\" placeholder=\"Subject\">\n        <button id=\"allot-btn\">Allot Subject</button>\n\n        <h3>Change Student Information</h3>\n        <input type=\"text\" id=\"student-name\" placeholder=\"Student Name\">\n        <input type=\"number\" id=\"student-id\" placeholder=\"Student ID\">\n        <button id=\"update-student-btn\">Update Student</button>\n\n        <h3>Change Attendance</h3>\n        <input type=\"number\" id=\"attendance-student-id\" placeholder=\"Student ID\">\n        <input type=\"text\" id=\"attendance-subject\" placeholder=\"Subject\">\n        <input type=\"checkbox\" id=\"attendance-status\"> Present\n        <button id=\"change-attendance-btn\">Change Attendance</button>\n\n        <h3>Current Teachers</h3>\n        <ul id=\"teacher-list\"></ul>\n\n        <h3>Current Students</h3>\n        <ul id=\"student-list\"></ul>\n    ";
    document.getElementById('allot-btn').addEventListener('click', allotTeacherSubject);
    document.getElementById('update-student-btn').addEventListener('click', updateStudentInfo);
    document.getElementById('change-attendance-btn').addEventListener('click', changeAttendance);
    updateTeacherList();
    updateStudentList();
}
function allotTeacherSubject() {
    var teacherName = document.getElementById('teacher-name').value;
    var subject = document.getElementById('subject').value;
    if (teacherName && subject) {
        var newTeacher = { id: adminData.teachers.length + 1, name: teacherName, subject: subject };
        adminData.teachers.push(newTeacher);
        alert("".concat(teacherName, " has been allotted ").concat(subject));
        updateTeacherList();
    }
}
function updateStudentInfo() {
    var studentName = document.getElementById('student-name').value;
    var studentId = parseInt(document.getElementById('student-id').value);
    if (studentName && studentId) {
        var studentIndex = adminData.students.findIndex(function (s) { return s.id === studentId; });
        if (studentIndex >= 0) {
            adminData.students[studentIndex].name = studentName;
            alert("Student ID ".concat(studentId, " updated to ").concat(studentName));
        }
        else {
            alert('Student not found');
        }
    }
}
function changeAttendance() {
    var studentId = parseInt(document.getElementById('attendance-student-id').value);
    var subject = document.getElementById('attendance-subject').value;
    var isPresent = document.getElementById('attendance-status').checked;
    var student = adminData.students.find(function (s) { return s.id === studentId; });
    if (student) {
        student.attendance[subject] = isPresent;
        alert("Attendance for Student ID ".concat(studentId, " in ").concat(subject, " marked as ").concat(isPresent ? 'Present' : 'Absent'));
    }
    else {
        alert('Student not found');
    }
}
function updateTeacherList() {
    var teacherList = document.getElementById('teacher-list');
    teacherList.innerHTML = '';
    adminData.teachers.forEach(function (teacher) {
        var li = document.createElement('li');
        li.textContent = "".concat(teacher.name, " - ").concat(teacher.subject);
        teacherList.appendChild(li);
    });
}
function updateStudentList() {
    var studentList = document.getElementById('student-list');
    studentList.innerHTML = '';
    adminData.students.forEach(function (student) {
        var li = document.createElement('li');
        li.textContent = "".concat(student.id, " - ").concat(student.name);
        studentList.appendChild(li);
    });
}
function renderTeacherPortal(portal) {
    portal.innerHTML = "<h2>Teacher Portal</h2>\n        <h3>Grade Students</h3>\n        <input type=\"number\" id=\"student-id-grade\" placeholder=\"Student ID\">\n        <input type=\"text\" id=\"grade\" placeholder=\"Grade\">\n        <button id=\"grade-btn\">Submit Grade</button>\n\n        <h3>Mark Attendance</h3>\n        <input type=\"number\" id=\"attendance-student-id-teacher\" placeholder=\"Student ID\">\n        <input type=\"text\" id=\"attendance-subject-teacher\" placeholder=\"Subject\">\n        <input type=\"checkbox\" id=\"attendance-status-teacher\"> Present\n        <button id=\"mark-attendance-btn\">Mark Attendance</button>\n    ";
    document.getElementById('grade-btn').addEventListener('click', gradeStudent);
    document.getElementById('mark-attendance-btn').addEventListener('click', markAttendance);
}
function gradeStudent() {
    var studentId = parseInt(document.getElementById('student-id-grade').value);
    var grade = document.getElementById('grade').value;
    // Logic to store or display the grade
    alert("Graded Student ID ".concat(studentId, " with ").concat(grade));
}
function markAttendance() {
    var studentId = parseInt(document.getElementById('attendance-student-id-teacher').value);
    var subject = document.getElementById('attendance-subject-teacher').value;
    var isPresent = document.getElementById('attendance-status-teacher').checked;
    var student = adminData.students.find(function (s) { return s.id === studentId; });
    if (student) {
        student.attendance[subject] = isPresent;
        alert("Attendance for Student ID ".concat(studentId, " in ").concat(subject, " marked as ").concat(isPresent ? 'Present' : 'Absent'));
    }
    else {
        alert('Student not found');
    }
}
function renderStudentPortal(portal) {
    portal.innerHTML = "<h2>Student Portal</h2>\n        <h3>Available Subjects</h3>\n        <ul id=\"available-subjects\"></ul>\n        <h3>Enroll in a Subject</h3>\n        <input type=\"text\" id=\"subject-to-enroll\" placeholder=\"Subject\">\n        <button id=\"enroll-btn\">Enroll</button>\n    ";
    var availableSubjects = adminData.teachers.map(function (t) { return t.subject; });
    var uniqueSubjects = __spreadArray([], new Set(availableSubjects), true);
    var subjectList = document.getElementById('available-subjects');
    uniqueSubjects.forEach(function (subject) {
        var li = document.createElement('li');
        li.textContent = subject;
        subjectList.appendChild(li);
    });
    document.getElementById('enroll-btn').addEventListener('click', enrollInSubject);
}
function enrollInSubject() {
    var subject = document.getElementById('subject-to-enroll').value;
    var studentId = prompt('Enter your Student ID:');
    if (studentId) {
        var student = adminData.students.find(function (s) { return s.id === parseInt(studentId); });
        if (student) {
            student.enrolledSubjects.push(subject);
            alert("Enrolled in ".concat(subject));
        }
        else {
            alert('Student not found');
        }
    }
}
// Event listeners for the main buttons
document.getElementById('admin-btn').addEventListener('click', function () { return renderPortal('admin'); });
document.getElementById('teacher-btn').addEventListener('click', function () { return renderPortal('teacher'); });
document.getElementById('student-btn').addEventListener('click', function () { return renderPortal('student'); });
