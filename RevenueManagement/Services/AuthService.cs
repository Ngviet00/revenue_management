using RevenueManagement.Context;
using LoginRequest = RevenueManagement.Models.Requests.Auth.LoginRequest;
using Microsoft.EntityFrameworkCore;
using AutoMapper;
using RevenueManagement.Models.DTOs.User;

namespace RevenueManagement.Services
{
    public class AuthService
    {
        private readonly ApplicationDbContext _context;
        private readonly IMapper _mapper;

        public AuthService(ApplicationDbContext _context, IMapper _mapper)
        {
            this._context = _context;
            this._mapper = _mapper;
        }

        public async Task<UserDto> Login(LoginRequest loginRequest)
        {
            var password = Utils.Security.MD5Hash(loginRequest.Password);
            var user = _mapper.Map<UserDto>(await _context.Users.FirstOrDefaultAsync(x => x.Username == loginRequest.Username && x.Password == password));
            return user;
        }
    }
}
