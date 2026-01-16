import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class Course {
  private coursesSubject = new BehaviorSubject<any[]>([]);
  courses$ = this.coursesSubject.asObservable();

  api = 'http://localhost:8000/api/courses';

  constructor(private http: HttpClient) {
    this.load();
  }

  load(search: string = '', sortBy: string = 'created_at', sortOrder: string = 'desc', page: number = 1) {
    const params = `?search=${search}&sortBy=${sortBy}&sortOrder=${sortOrder}&page=${page}`;
    this.http.get<any>(`${this.api}${params}`)
      .subscribe(res => this.coursesSubject.next(res.data));
  }

  getById(id: number) {
    return this.http.get<any>(`${this.api}/${id}`);
  }

  create(course: any) {
    return this.http.post(this.api, course);
  }

  update(id: number, course: any) {
    return this.http.put(`${this.api}/${id}`, course);
  }

  delete(id: number) {
    return this.http.delete(`${this.api}/${id}`);
  }

  addLocal(course: any) {
    this.coursesSubject.next([...this.coursesSubject.value, course]);
  }
}