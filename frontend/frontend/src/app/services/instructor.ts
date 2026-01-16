import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class Instructor {
  private instructorsSubject = new BehaviorSubject<any[]>([]);
  instructors$ = this.instructorsSubject.asObservable();

  api = 'http://localhost:8000/api/instructors';

  constructor(private http: HttpClient) {
    this.load();
  }

  load(search: string = '', sortBy: string = 'name', sortOrder: string = 'asc') {
    const params = `?search=${search}&sortBy=${sortBy}&sortOrder=${sortOrder}`;
    this.http.get<any>(`${this.api}${params}`)
      .subscribe(res => this.instructorsSubject.next(res.data || res));
  }

  getById(id: number) {
    return this.http.get<any>(`${this.api}/${id}`);
  }

  create(instructor: any) {
    return this.http.post(this.api, instructor);
  }

  update(id: number, instructor: any) {
    return this.http.put(`${this.api}/${id}`, instructor);
  }

  delete(id: number) {
    return this.http.delete(`${this.api}/${id}`);
  }
}
