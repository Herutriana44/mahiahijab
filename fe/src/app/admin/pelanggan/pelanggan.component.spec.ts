import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HttpClientTestingModule } from '@angular/common/http/testing';
import { AdminPelangganComponent } from './pelanggan.component';
import { CommonModule } from '@angular/common';
import { SidebarComponent } from '../left-sidebar/left-sidebar.component';
import { HttpClient } from '@angular/common/http';
import { of } from 'rxjs';

describe('AdminPelangganComponent', () => {
  let component: AdminPelangganComponent;
  let fixture: ComponentFixture<AdminPelangganComponent>;
  let httpClientSpy: jasmine.SpyObj<HttpClient>;

  beforeEach(async () => {
    httpClientSpy = jasmine.createSpyObj('HttpClient', ['get', 'delete']);
    
    await TestBed.configureTestingModule({
      imports: [CommonModule, HttpClientTestingModule],
      declarations: [AdminPelangganComponent, SidebarComponent],
      providers: [{ provide: HttpClient, useValue: httpClientSpy }]
    }).compileComponents();

    fixture = TestBed.createComponent(AdminPelangganComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('should fetch pelanggan data on init', () => {
    const mockData = { data: [{ id: '1', name: 'John Doe' }] };
    httpClientSpy.get.and.returnValue(of(mockData));

    component.getPelanggan();
    expect(component.pelangganList.length).toBe(1);
    expect(component.pelangganList[0].name).toBe('John Doe');
  });

  it('should delete pelanggan and refresh data', () => {
    spyOn(window, 'confirm').and.returnValue(true);
    const mockResponse = { status: 'success' };
    httpClientSpy.delete.and.returnValue(of(mockResponse));
    spyOn(component, 'getPelanggan');

    component.deletePelanggan('1');

    expect(httpClientSpy.delete).toHaveBeenCalled();
    expect(component.getPelanggan).toHaveBeenCalled();
  });
});