import { Component } from '@angular/core';
import { Instructor } from '../../services/instructor';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-instructors',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './instructors.html',
  styleUrl: './instructors.css',
})
export class Instructors {
  instructors$;
  search$ = new Subject<string>();
  searchValue = '';
  
  showForm = false;
  instructorForm: FormGroup;
  editingId: number | null = null;
  
  sortBy = 'name';
  sortOrder = 'asc';

  constructor(
    private instructorService: Instructor,
    private fb: FormBuilder
  ) {
    this.instructors$ = this.instructorService.instructors$;
    
    this.instructorForm = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      phone: [''],
      expertise: ['', Validators.required],
      bio: ['']
    });
    
    this.search$.pipe(debounceTime(300))
      .subscribe(v => {
        this.searchValue = v;
        this.instructorService.load(v, this.sortBy, this.sortOrder);
      });
  }

  openForm() {
    this.showForm = true;
    this.editingId = null;
    this.instructorForm.reset();
  }

  edit(instructor: any) {
    this.showForm = true;
    this.editingId = instructor.id;
    this.instructorForm.patchValue(instructor);
  }

  save() {
    if (this.instructorForm.invalid) return;
    
    const data = this.instructorForm.value;
    
    if (this.editingId) {
      this.instructorService.update(this.editingId, data).subscribe(() => {
        this.instructorService.load(this.searchValue, this.sortBy, this.sortOrder);
        this.closeForm();
      });
    } else {
      this.instructorService.create(data).subscribe(() => {
        this.instructorService.load(this.searchValue, this.sortBy, this.sortOrder);
        this.closeForm();
      });
    }
  }

  closeForm() {
    this.showForm = false;
    this.instructorForm.reset();
    this.editingId = null;
  }

  del(id: number) {
    if (confirm('Are you sure?')) {
      this.instructorService.delete(id).subscribe(() => 
        this.instructorService.load(this.searchValue, this.sortBy, this.sortOrder)
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
    this.instructorService.load(this.searchValue, this.sortBy, this.sortOrder);
  }
}
