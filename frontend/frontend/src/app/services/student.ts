import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class Student {
  private studentsSubject = new BehaviorSubject<any[]>([]);
  students$ = this.studentsSubject.asObservable();

  api = 'http://localhost:8000/api/students';

  constructor(private http: HttpClient) {
    this.load();
  }

  load(search: string = '', sortBy: string = 'name', sortOrder: string = 'asc') {
    const params = `?search=${search}&sortBy=${sortBy}&sortOrder=${sortOrder}`;
    this.http.get<any>(`${this.api}${params}`)
      .subscribe(res => this.studentsSubject.next(res.data || res));
  }

  getById(id: number) {
    return this.http.get<any>(`${this.api}/${id}`);
  }

  create(student: any) {
    return this.http.post(this.api, student);
  }

  update(id: number, student: any) {
    return this.http.put(`${this.api}/${id}`, student);
  }

  delete(id: number) {
    return this.http.delete(`${this.api}/${id}`);
  }

  assignCourse(studentId: number, courseId: number) {
    return this.http.post(`${this.api}/${studentId}/courses`, { course_id: courseId });
  }

  removeCourse(studentId: number, courseId: number) {
    return this.http.delete(`${this.api}/${studentId}/courses/${courseId}`);
  }
}
