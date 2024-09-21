// Define types for user roles
type UserRole = 'admin' | 'teacher' | 'student';

// Function to render the appropriate portal
function renderPortal(role: UserRole) {
    const portal = document.getElementById('portal')!;
    portal.innerHTML = '';

    switch (role) {
        case 'admin':
            portal.innerHTML = `<h2>Admin Portal</h2><p>Manage users, courses, and settings.</p>`;
            break;
        case 'teacher':
            portal.innerHTML = `<h2>Teacher Portal</h2><p>Manage courses and student progress.</p>`;
            break;
        case 'student':
            portal.innerHTML = `<h2>Student Portal</h2><p>View courses and submit assignments.</p>`;
            break;
    }
    portal.style.display = 'block';
}

// Set up event listeners for buttons
document.getElementById('admin-btn')!.addEventListener('click', () => renderPortal('admin'));
document.getElementById('teacher-btn')!.addEventListener('click', () => renderPortal('teacher'));
document.getElementById('student-btn')!.addEventListener('click', () => renderPortal('student'));
