import { Component } from '@angular/core';
import { Student } from '../../services/student';
import { Course } from '../../services/course';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-students',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './students.html',
  styleUrl: './students.css',
})
export class Students {
  students$;
  courses$;
  search$ = new Subject<string>();
  searchValue = '';
  
  showForm = false;
  showCourseAssign = false;
  studentForm: FormGroup;
  editingId: number | null = null;
  selectedStudent: any = null;
  
  sortBy = 'name';
  sortOrder = 'asc';

  constructor(
    private studentService: Student,
    private courseService: Course,
    private fb: FormBuilder
  ) {
    this.students$ = this.studentService.students$;
    this.courses$ = this.courseService.courses$;
    
    this.studentForm = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      phone: [''],
      address: ['']
    });
    
    this.search$.pipe(debounceTime(300))
      .subscribe(v => {
        this.searchValue = v;
        this.studentService.load(v, this.sortBy, this.sortOrder);
      });
  }

  openForm() {
    this.showForm = true;
    this.editingId = null;
    this.studentForm.reset();
  }

  edit(student: any) {
    this.showForm = true;
    this.editingId = student.id;
    this.studentForm.patchValue(student);
  }

  save() {
    if (this.studentForm.invalid) return;
    
    const data = this.studentForm.value;
    
    if (this.editingId) {
      this.studentService.update(this.editingId, data).subscribe(() => {
        this.studentService.load(this.searchValue, this.sortBy, this.sortOrder);
        this.closeForm();
      });
    } else {
      this.studentService.create(data).subscribe(() => {
        this.studentService.load(this.searchValue, this.sortBy, this.sortOrder);
        this.closeForm();
      });
    }
  }

  closeForm() {
    this.showForm = false;
    this.studentForm.reset();
    this.editingId = null;
  }

  del(id: number) {
    if (confirm('Are you sure?')) {
      this.studentService.delete(id).subscribe(() => 
        this.studentService.load(this.searchValue, this.sortBy, this.sortOrder)
      );
    }
  }

  sort(field: string) {
    if (this.sortBy === field) {
      this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortBy = field;
      this.sortOrder = 'asc';
    }
    this.studentService.load(this.searchValue, this.sortBy, this.sortOrder);
  }

  openCourseAssign(student: any) {
    this.selectedStudent = student;
    this.showCourseAssign = true;
  }

  closeCourseAssign() {
    this.showCourseAssign = false;
    this.selectedStudent = null;
  }

  assignCourse(courseId: number) {
    if (this.selectedStudent) {
      this.studentService.assignCourse(this.selectedStudent.id, courseId).subscribe(() => {
        alert('Course assigned successfully!');
        this.closeCourseAssign();
      });
    }
  }

  removeCourse(studentId: number, courseId: number) {
    if (confirm('Remove this course?')) {
      this.studentService.removeCourse(studentId, courseId).subscribe(() => {
        this.studentService.load(this.searchValue, this.sortBy, this.sortOrder);
      });
    }
  }
}
