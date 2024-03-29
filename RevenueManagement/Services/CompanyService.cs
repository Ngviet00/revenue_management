﻿using AutoMapper;
using RevenueManagement.Context;

namespace RevenueManagement.Services
{
    public class CompanyService
    {
        private readonly ApplicationDbContext _context;
        private readonly IMapper _mapper;

        public CompanyService(ApplicationDbContext _context, IMapper _mapper)
        {
            this._context = _context;
            this._mapper = _mapper;
        }
    }
}
