import { Component } from '@angular/core';
import { Course } from '../../services/course';
import { Websocket } from '../../services/websocket';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-courses',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './courses.html',
  styleUrl: './courses.css',
})
export class Courses {
  courses$;
  search$ = new Subject<string>();
  searchValue = '';
  
  showForm = false;
  courseForm: FormGroup;
  editingId: number | null = null;
  
  sortBy = 'created_at';
  sortOrder = 'desc';
  currentPage = 1;

  constructor(
    private cs: Course,
    ws: Websocket,
    private fb: FormBuilder
  ) {
    this.courses$ = this.cs.courses$;
    
    this.courseForm = this.fb.group({
      title: ['', Validators.required],
      description: ['', Validators.required],
      status: ['planned', Validators.required],
      difficulty: ['beginner', Validators.required],
      instructor: ['', Validators.required]
    });
    
    this.search$.pipe(debounceTime(300))
      .subscribe(v => {
        this.searchValue = v;
        this.cs.load(v, this.sortBy, this.sortOrder, this.currentPage);
      });

    ws.connect(course => this.cs.addLocal(course));
  }

  openForm() {
    this.showForm = true;
    this.editingId = null;
    this.courseForm.reset({
      status: 'planned',
      difficulty: 'beginner'
    });
  }

  edit(course: any) {
    this.showForm = true;
    this.editingId = course.id;
    this.courseForm.patchValue(course);
  }

  save() {
    if (this.courseForm.invalid) return;
    
    const data = this.courseForm.value;
    
    if (this.editingId) {
      this.cs.update(this.editingId, data).subscribe(() => {
        this.cs.load(this.searchValue, this.sortBy, this.sortOrder, this.currentPage);
        this.closeForm();
      });
    } else {
      this.cs.create(data).subscribe(() => {
        this.cs.load(this.searchValue, this.sortBy, this.sortOrder, this.currentPage);
        this.closeForm();
      });
    }
  }

  closeForm() {
    this.showForm = false;
    this.courseForm.reset();
    this.editingId = null;
  }

  del(id: number) {
    if (confirm('Are you sure?')) {
      this.cs.delete(id).subscribe(() => 
        this.cs.load(this.searchValue, this.sortBy, this.sortOrder, this.currentPage)
      );
    }
  }

  sort(field: string) {
    if (this.sortBy === field) {
      this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortBy = field;
      this.sortOrder = 'desc';
    }
    this.cs.load(this.searchValue, this.sortBy, this.sortOrder, this.currentPage);
  }

  changePage(page: number) {
    this.currentPage = page;
    this.cs.load(this.searchValue, this.sortBy, this.sortOrder, this.currentPage);
  }
}