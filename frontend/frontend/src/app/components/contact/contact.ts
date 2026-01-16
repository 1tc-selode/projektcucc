import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-contact',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './contact.html',
  styleUrl: './contact.css',
})
export class Contact {
  contactForm: FormGroup;
  submitted = false;
  success = false;
  error = false;

  constructor(
    private fb: FormBuilder,
    private http: HttpClient
  ) {
    this.contactForm = this.fb.group({
      name: ['', [Validators.required, Validators.minLength(3)]],
      email: ['', [Validators.required, Validators.email]],
      message: ['', [Validators.required, Validators.minLength(10)]]
    });
  }

  get name() {
    return this.contactForm.get('name');
  }

  get email() {
    return this.contactForm.get('email');
  }

  get message() {
    return this.contactForm.get('message');
  }

  onSubmit() {
    this.submitted = true;
    this.success = false;
    this.error = false;

    if (this.contactForm.invalid) {
      return;
    }

    // Send to backend
    this.http.post('http://localhost:8000/api/contact', this.contactForm.value)
      .subscribe({
        next: () => {
          this.success = true;
          this.contactForm.reset();
          this.submitted = false;
          setTimeout(() => this.success = false, 5000);
        },
        error: () => {
          this.error = true;
          setTimeout(() => this.error = false, 5000);
        }
      });
  }
}
