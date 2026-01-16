import { Component } from '@angular/core';
import { Course } from '../../services/course';
import { CommonModule } from '@angular/common';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-dashboard',
  imports: [CommonModule],
  templateUrl: './dashboard.html',
  styleUrl: './dashboard.css',
})
export class Dashboard {
  courses$;
  totalCourses$;
  activeCourses$;
  completedCourses$;
  valami: string = 'dashboard';
  
  constructor(private course: Course) {
    this.courses$ = this.course.courses$;
    
    this.totalCourses$ = this.courses$.pipe(
      map(courses => courses.length)
    );
    
    this.activeCourses$ = this.courses$.pipe(
      map(courses => courses.filter(c => c.status === 'active').length)
    );
    
    this.completedCourses$ = this.courses$.pipe(
      map(courses => courses.filter(c => c.status === 'completed').length)
    );
  }
}