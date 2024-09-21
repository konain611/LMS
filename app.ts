// Types for roles and data structure
type UserRole = 'admin' | 'teacher' | 'student';

interface Student {
    id: number;
    name: string;
    enrolledSubjects: string[];
    attendance: { [subject: string]: boolean };
}

interface Teacher {
    id: number;
    name: string;
    subject: string;
}

interface Admin {
    teachers: Teacher[];
    students: Student[];
}

// Sample data
const adminData: Admin = {
    teachers: [],
    students: []
};

function renderPortal(role: UserRole) {
    const portal = document.getElementById('portal')!;
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

function renderAdminPortal(portal: HTMLElement) {
    portal.innerHTML = `<h2>Admin Portal</h2>
        <h3>Allot Teacher Subjects</h3>
        <input type="text" id="teacher-name" placeholder="Teacher Name">
        <input type="text" id="subject" placeholder="Subject">
        <button id="allot-btn">Allot Subject</button>

        <h3>Change Student Information</h3>
        <input type="text" id="student-name" placeholder="Student Name">
        <input type="number" id="student-id" placeholder="Student ID">
        <button id="update-student-btn">Update Student</button>

        <h3>Change Attendance</h3>
        <input type="number" id="attendance-student-id" placeholder="Student ID">
        <input type="text" id="attendance-subject" placeholder="Subject">
        <input type="checkbox" id="attendance-status"> Present
        <button id="change-attendance-btn">Change Attendance</button>

        <h3>Current Teachers</h3>
        <ul id="teacher-list"></ul>

        <h3>Current Students</h3>
        <ul id="student-list"></ul>
    `;

    document.getElementById('allot-btn')!.addEventListener('click', allotTeacherSubject);
    document.getElementById('update-student-btn')!.addEventListener('click', updateStudentInfo);
    document.getElementById('change-attendance-btn')!.addEventListener('click', changeAttendance);

    updateTeacherList();
    updateStudentList();
}

function allotTeacherSubject() {
    const teacherName = (document.getElementById('teacher-name') as HTMLInputElement).value;
    const subject = (document.getElementById('subject') as HTMLInputElement).value;

    if (teacherName && subject) {
        const newTeacher = { id: adminData.teachers.length + 1, name: teacherName, subject: subject };
        adminData.teachers.push(newTeacher);
        alert(`${teacherName} has been allotted ${subject}`);
        updateTeacherList();
    }
}

function updateStudentInfo() {
    const studentName = (document.getElementById('student-name') as HTMLInputElement).value;
    const studentId = parseInt((document.getElementById('student-id') as HTMLInputElement).value);

    if (studentName && studentId) {
        const studentIndex = adminData.students.findIndex(s => s.id === studentId);
        if (studentIndex >= 0) {
            adminData.students[studentIndex].name = studentName;
            alert(`Student ID ${studentId} updated to ${studentName}`);
        } else {
            alert('Student not found');
        }
    }
}

function changeAttendance() {
    const studentId = parseInt((document.getElementById('attendance-student-id') as HTMLInputElement).value);
    const subject = (document.getElementById('attendance-subject') as HTMLInputElement).value;
    const isPresent = (document.getElementById('attendance-status') as HTMLInputElement).checked;

    const student = adminData.students.find(s => s.id === studentId);
    if (student) {
        student.attendance[subject] = isPresent;
        alert(`Attendance for Student ID ${studentId} in ${subject} marked as ${isPresent ? 'Present' : 'Absent'}`);
    } else {
        alert('Student not found');
    }
}

function updateTeacherList() {
    const teacherList = document.getElementById('teacher-list')!;
    teacherList.innerHTML = '';
    adminData.teachers.forEach(teacher => {
        const li = document.createElement('li');
        li.textContent = `${teacher.name} - ${teacher.subject}`;
        teacherList.appendChild(li);
    });
}

function updateStudentList() {
    const studentList = document.getElementById('student-list')!;
    studentList.innerHTML = '';
    adminData.students.forEach(student => {
        const li = document.createElement('li');
        li.textContent = `${student.id} - ${student.name}`;
        studentList.appendChild(li);
    });
}

function renderTeacherPortal(portal: HTMLElement) {
    portal.innerHTML = `<h2>Teacher Portal</h2>
        <h3>Grade Students</h3>
        <input type="number" id="student-id-grade" placeholder="Student ID">
        <input type="text" id="grade" placeholder="Grade">
        <button id="grade-btn">Submit Grade</button>

        <h3>Mark Attendance</h3>
        <input type="number" id="attendance-student-id-teacher" placeholder="Student ID">
        <input type="text" id="attendance-subject-teacher" placeholder="Subject">
        <input type="checkbox" id="attendance-status-teacher"> Present
        <button id="mark-attendance-btn">Mark Attendance</button>
    `   ;

    document.getElementById('grade-btn')!.addEventListener('click', gradeStudent);
    document.getElementById('mark-attendance-btn')!.addEventListener('click', markAttendance);
}

function gradeStudent() {
    const studentId = parseInt((document.getElementById('student-id-grade') as HTMLInputElement).value);
    const grade = (document.getElementById('grade') as HTMLInputElement).value;

    // Logic to store or display the grade
    alert(`Graded Student ID ${studentId} with ${grade}`);
}

function markAttendance() {
    const studentId = parseInt((document.getElementById('attendance-student-id-teacher') as HTMLInputElement).value);
    const subject = (document.getElementById('attendance-subject-teacher') as HTMLInputElement).value;
    const isPresent = (document.getElementById('attendance-status-teacher') as HTMLInputElement).checked;

    const student = adminData.students.find(s => s.id === studentId);
    if (student) {
        student.attendance[subject] = isPresent;
        alert(`Attendance for Student ID ${studentId} in ${subject} marked as ${isPresent ? 'Present' : 'Absent'}`);
    } else {
        alert('Student not found');
    }
}

function renderStudentPortal(portal: HTMLElement) {
    portal.innerHTML = `<h2>Student Portal</h2>
        <h3>Available Subjects</h3>
        <ul id="available-subjects"></ul>
        <h3>Enroll in a Subject</h3>
        <input type="text" id="subject-to-enroll" placeholder="Subject">
        <button id="enroll-btn">Enroll</button>
    `;

    const availableSubjects = adminData.teachers.map(t => t.subject);
    const uniqueSubjects = [...new Set(availableSubjects)];
    const subjectList = document.getElementById('available-subjects')!;
    uniqueSubjects.forEach(subject => {
        const li = document.createElement('li');
        li.textContent = subject;
        subjectList.appendChild(li);
    });

    document.getElementById('enroll-btn')!.addEventListener('click', enrollInSubject);
}

function enrollInSubject() {
    const subject = (document.getElementById('subject-to-enroll') as HTMLInputElement).value;

    const studentId = prompt('Enter your Student ID:');
    if (studentId) {
        const student = adminData.students.find(s => s.id === parseInt(studentId));
        if (student) {
            student.enrolledSubjects.push(subject);
            alert(`Enrolled in ${subject}`);
        } else {
            alert('Student not found');
        }
    }
}

// Event listeners for the main buttons
document.getElementById('admin-btn')!.addEventListener('click', () => renderPortal('admin'));
document.getElementById('teacher-btn')!.addEventListener('click', () => renderPortal('teacher'));
document.getElementById('student-btn')!.addEventListener('click', () => renderPortal('student'));
