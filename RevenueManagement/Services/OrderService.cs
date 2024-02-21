using AutoMapper;
using RevenueManagement.Context;

namespace RevenueManagement.Services
{
    public class OrderService
    {
        private readonly ApplicationDbContext _context;
        private readonly IMapper _mapper;

        public OrderService(ApplicationDbContext _context, IMapper _mapper)
        {
            this._context = _context;
            this._mapper = _mapper;
        }
    }
}
